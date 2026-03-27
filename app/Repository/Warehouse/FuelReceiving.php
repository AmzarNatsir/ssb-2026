<?php
namespace App\Repository\Warehouse;

use App\Models\Warehouse\FuelReceiving as FuelReceivingModel;
use App\Repository\Warehouse\WarehouseRepository;
use PDF;


class FuelReceiving extends WarehouseRepository
{
    const NUMBER_PREFIX = 'FR.{year}.{month}.';
    public $model, $detail;
    protected $status;
    const SUBTITUTE_DETAIL_ATTRIBUTE_KEY = true;
    protected $defaultRelation = ['supplier'];

    public function __construct($id = null)
    {
        
        $this->model = new FuelReceivingModel;
        
        if ($id) {
            $this->model = $this->model::with('supplier')->findOrFail($id);
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
        $fuelReceiving = new $this->model;
        
        $fuelReceiving = $fuelReceiving->fill($attributes);

        $fuelReceiving->number = $this->generateNumber();

        $fuelReceiving->save();

        $fuelReceiving->increaseFuelTankStock();

        

        return $fuelReceiving;
    }

    public function update(array $attributes): object
    {
        $fuelReceiving = $this->model;

        $fuelReceiving->decreaseFuelTankStock();
        
        $fuelReceiving = $fuelReceiving->fill($attributes);

        $fuelReceiving->save();

        $fuelReceiving->increaseFuelTankStock();

        return $fuelReceiving;
        
    }

    public function remove(int $id = null ): bool
    {   
        $this->model->decreaseFuelTankStock();

        return $this->model->delete();
    }

}
