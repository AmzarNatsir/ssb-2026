<?php
namespace App\Repository\Warehouse;

use App\Models\Warehouse\PartReturn as PartReturnModel;
use App\Models\Warehouse\PartReturnDetail as PartReturnDetailModel;
use App\Repository\Warehouse\WarehouseRepository;
use PDF;


class PartReturn extends WarehouseRepository
{
    const NUMBER_PREFIX = 'PRT.{year}.{month}.';
    public $model, $detail;
    protected $status;
    const SUBTITUTE_DETAIL_ATTRIBUTE_KEY = false;

    public function __construct($id = null)
    {
        
        $this->model = new PartReturnModel;
        $this->detail = new PartReturnDetailModel;
        
        if ($id) {
            $this->model = $this->model::with('details.sparepart.brand','details.sparepart.uop')->findOrFail($id);
            $this->status = $this->model->status;
        }
    }
    
    public function print()
    {
        $pdf = PDF::loadView('Warehouse.part-return.print', ['part_return' => $this]);
        return $pdf->stream();

        // return view('Warehouse.part-return.print', ['part_return' => $this]);
        
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
        $partReturn = parent::create($attributes);

        $partReturn->model->syncPurchasingOrder();
        $partReturn->model->updatePurchasingOrder();

        return $partReturn;
    }

    public function update(array $attributes): object
    {
        $partReturn = parent::update($attributes);

        $partReturn->model->syncPurchasingOrder();
        $partReturn->model->updatePurchasingOrder();

        return $partReturn;
        
    }

    public function remove(int $id = null ): bool
    {
        
        $this->model->syncPurchasingOrder(false);
        
        return parent::remove($id);
    }

    public function release()
    {
        return $this->model->release();
    }

}
