<?php

namespace App\Repository\Warehouse;

use App\Models\Warehouse\Issued;
use App\Models\Warehouse\PurchasingRequest as PurchasingRequestModel;
use App\Models\Warehouse\PurchasingRequestDetail as PurchasingRequestDetailModel;
use PDF;

class PurchasingRequest extends WarehouseRepository
{
    const NUMBER_PREFIX = 'WSP {number}';
    public $model, $detail;
    protected $status;


    public function __construct($id = null)
    {

        $this->model = new PurchasingRequestModel;
        $this->detail = new PurchasingRequestDetailModel;

        if ($id) {
            $this->model = $this->model::with('details.sparepart.brand', 'details.sparepart.uop')->findOrFail($id);
            $this->status = $this->model->status;
        }
    }

    public function print()
    {
        // return view('Warehouse.purchasing-request.print', ['purchasing_request' => $this]);
        $pdf = PDF::loadView('Warehouse.purchasing-request.print', ['purchasing_request' => $this]);
        return $pdf->stream();
    }

    protected function updateStatusOnReference()
    {
        $reference_part = $this->model->work_order->work_request->part_order;
        $details = $this->model->details;

        $issued = Issued::where('reference_id', $this->model->reference_id)->first();

        foreach ($reference_part->whereIn('part_id', $details->pluck('part_id')) as $key => $value) {
            $value->update(['status' => 1]);
        }

        if (!$issued) {
            foreach ($reference_part->whereNotIn('part_id', $details->pluck('part_id')) as $key => $value) {
                $value->update(['status' => 0]);
            }
        }
    }

    protected function redoStatusOnReference()
    {
        $reference_part = $this->model->work_order->work_request->part_order;
        $details = $this->model->details;

        foreach ($reference_part->whereIn('part_id', $details->pluck('part_id')) as $key => $value) {
            $value->update(['status' => 0]);
        }
    }
}
