<?php
namespace App\Repository\Warehouse;

use App\Models\Warehouse\Receiving as ReceivingModel;
use App\Models\Warehouse\ReceivingDetail as ReceivingDetailModel;
use App\Repository\Warehouse\WarehouseRepository;
use PDF;


class Receiving extends WarehouseRepository
{
    const NUMBER_PREFIX = 'RI.{year}.{month}.';
    public $model, $detail;
    protected $status;
    const SUBTITUTE_DETAIL_ATTRIBUTE_KEY = false;

    public function __construct($id = null)
    {
        
        $this->model = new ReceivingModel;
        $this->detail = new ReceivingDetailModel;
        
        if ($id) {
            $this->model = $this->model::with('details.sparepart.brand','details.sparepart.uop')->findOrFail($id);
            $this->status = $this->model->status;
        }
    }
    
    public function print()
    {
        $pdf = PDF::loadView('Warehouse.receiving.print', ['receiving' => $this]);
        return $pdf->stream();

        // return view('Warehouse.receiving.print', ['receiving' => $this]);
        
    }

    public function generateNumber(): string
    {
        $lastNumber = $this->getLastNumber() + 1 ;
        
        return $this->extractPrefix().$this->numbering($lastNumber);
    }

    public function getLastNumber(): int
    {
        $lastNumber =  $this->model->selectRaw("CAST(SUBSTR(number,-5,5) as UNSIGNED) AS latest_number")
            ->whereRaw("number like '".$this->extractPrefix()."%'")
            ->orderByRaw('CAST(SUBSTR(number,-5,5) as UNSIGNED) DESC')
            ->limit(1)
            ->get('latest_number');

        return $lastNumber->count() ? $lastNumber->first()->latest_number : 0;
    }

    public function create(array $attributes = null ): object
    {
        $receiving = parent::create($attributes);

        $receiving->model->syncPurchasingOrder();
        $receiving->model->updatePurchasingOrder();

        $receiving->model->increaseSparePartStock();

        return $receiving;
    }

    public function update(array $attributes): object
    {
        $this->model->decreaseSparePartStock();

        $receiving = parent::update($attributes);

        $receiving->model->syncPurchasingOrder();
        $receiving->model->updatePurchasingOrder();

        $receiving->model->increaseSparePartStock();

        return $receiving;
        
    }

    public function remove(int $id = null ): bool
    {
        
        $this->model->decreaseSparePartStock();
        
        return parent::remove($id);
    }

}
