<?php
namespace App\Repository\Warehouse;

use App\Models\Warehouse\Issued as IssuedModel;
use App\Models\Warehouse\IssuedDetail as IssuedDetailModel;
use App\Models\Warehouse\PurchasingRequest;
use App\Repository\Warehouse\WarehouseRepository;
use PDF;


class Issued extends WarehouseRepository
{
    const NUMBER_PREFIX = 'PI.{year}.{month}.';
    public $model, $detail;
    protected $status;
    const SUBTITUTE_DETAIL_ATTRIBUTE_KEY = true;

    public function __construct($id = null)
    {
        
        $this->model = new IssuedModel;
        $this->detail = new IssuedDetailModel;
        
        if ($id) {
            $this->model = $this->model::with('details.sparepart.brand','details.sparepart.uop')->findOrFail($id);
            $this->status = $this->model->status;
        }
    }
    
    public function print()
    {
        $pdf = PDF::loadView('Warehouse.issued.print', ['issued' => $this]);
        return $pdf->stream();

        // return view('Warehouse.issued.print', ['issued' => $this]);
        
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
        if (array_key_exists('issued_immediately',$attributes)) {
            foreach ($attributes['part_id'] as $key => $items) {
                $attributes['part_remarks'][$key] = 'from receiving with invoice number '.$attributes['invoice_number'];
            }
        }
        
        $issued = parent::create($attributes);

        $issued->model->decreaseSparePartStock();
        
        return $issued;
    }

    public function update(array $attributes): object
    {
        $this->model->increaseSparePartStock();

        $issued = parent::update($attributes);

        $issued->model->decreaseSparePartStock();

        return $issued;
        
    }

    public function remove(int $id = null ): bool
    {   
        $this->model->increaseSparePartStock();
        
        return parent::remove($id);
    }

    protected function updateStatusOnReference(){
        $reference_part = $this->model->work_order->work_request->part_order;
        $details = $this->model->details->pluck('part_id');

        $pr = PurchasingRequest::where('reference_id', $this->model->reference_id)->first();

        foreach ($reference_part->whereIn('part_id', $details ) as $key => $value) {
            $value->update(['status' => 1]);
        }

        if (!$pr) {
            foreach ($reference_part->whereNotIn('part_id', $details ) as $key => $value) {
                $value->update(['status' => 0]);
            }
        }


    }

    protected function redoStatusOnReference(){
        $reference_part = $this->model->work_order->work_request->part_order;
        $details = $this->model->details;

        foreach ($reference_part->whereIn('part_id', $details->pluck('part_id') ) as $key => $value) {
            $value->update(['status' => 0]);
        }
    }

}
