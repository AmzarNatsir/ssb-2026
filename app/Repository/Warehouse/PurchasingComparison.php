<?php

namespace App\Repository\Warehouse;

use App\Models\Warehouse\PurchasingComparison as PurchasingComparisonModel;
use App\Models\Warehouse\PurchasingComparisonDetail as PurchasingComparisonDetailModel;
use PDF;

class PurchasingComparison extends WarehouseRepository
{
    const NUMBER_PREFIX = 'WSC {number}';
    public $model, $detail;
    protected $status;
    

    public function __construct($id = null)
    {

        $this->model = new PurchasingComparisonModel;
        $this->detail = new PurchasingComparisonDetailModel;
        
        if ($id) {
            $this->model = $this->model::with('details.sparepart.brand','details.sparepart.uop')->findOrFail($id);
            $this->status = $this->model->status;
        }
    }
    
    public function print()
    {
        $pdf = PDF::loadView('Warehouse.purchasing-comparison.print', ['purchasing_comparison' => $this])->setPaper([0,0,500,1000], 'landscape');
        return $pdf->stream();

        // return view('Warehouse.purchasing-comparison.print', ['purchasing_comparison' => $this]);
        
    }

}