<?php

namespace App\Repository\Warehouse;

use App\Models\Warehouse\FuelTank;


class FuelChanges
{
    protected $model = \App\Models\Warehouse\FuelChanges::class;

    public $module, $fuel_tank_id, $reference_id, $reference, $method, $stock, $updated_stock ; 

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            
            $this->$key = $value;
            
        }

        $this->setModule();

        // $this->setReference();

        // $this->setReferenceId();
    }

    public static function captureChanges( array $options = []){

        $stockChangesRepository = new self($options);

        $stockChangesModel = new $stockChangesRepository->model;

        $stockChangesModel->module = $stockChangesRepository->module;

        $stockChangesModel->method = $stockChangesRepository->method;

        $stockChangesModel->fuel_tank_id = $stockChangesRepository->fuel_tank_id;

        $stockChangesModel->reference_id = $stockChangesRepository->reference_id;

        $stockChangesModel->reference = $stockChangesRepository->reference;

        $stockChangesModel->stock = $stockChangesRepository->stock;

        $stockChangesModel->updated_stock = $stockChangesRepository->updated_stock;
            
        $stockChangesModel->save();
       
    }

    public function setModule()
    {
        $action = app('request')->route()->getAction();

        $controller = class_basename($action['controller']);

        $this->module = $controller;
    }

    // private function setReference(){
    //     $this->reference =  '\App\Models\Warehouse\\'.substr($this->module,0, strpos($this->module, 'Controller'));
    // }

    // private function setReferenceId(){
    //     $this->reference_id = (new $this->reference)->latest()->first()->id;
    // }

}
