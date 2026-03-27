<?php
namespace App\Repository\Warehouse;

use App\Models\Warehouse\PurchasingOrder as PurcahsingOrderModel;
use App\Models\Warehouse\PurchasingOrderDetail as PurcahsingOrderModelDetail;
use App\Repository\Warehouse\WarehouseRepository;
use PDF;


class PurchasingOrder extends WarehouseRepository
{
    const NUMBER_PREFIX = 'PO.{year}.{month}.';
    public $model, $detail;
    protected $status;

    public function __construct($id = null)
    {

        $this->model = new PurcahsingOrderModel;
        $this->detail = new PurcahsingOrderModelDetail;
        
        if ($id) {
            $this->model = $this->model::with('details.sparepart.brand','details.sparepart.uop')->findOrFail($id);
            $this->status = $this->model->status;
        }
    }
    
    public function print()
    {
        $pdf = PDF::loadView('Warehouse.purchasing-order.print', ['purchasing_order' => $this]);

        return $pdf->stream();
        
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
}
