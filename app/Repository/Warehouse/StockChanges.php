<?php

namespace App\Repository\Warehouse;

class StockChanges
{
    protected $model = \App\Models\Warehouse\StockChanges::class;

    private $spare_part, $module, $reference, $reference_id, $method, $stock, $updated_stock ; 

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            
            $this->$key = $value;
            
        }

        $this->setModule();
    }

    public static function captureChanges( array $options = []){

        $stockChangesRepository = new self($options);

        $stockChangesModel = new $stockChangesRepository->model;

        $stockChangesModel->spare_part_id = $stockChangesRepository->spare_part->id;

        $stockChangesModel->module = $stockChangesRepository->module;

        $stockChangesModel->reference = $stockChangesRepository->reference ;

        $stockChangesModel->reference_id = $stockChangesRepository->reference_id;

        $stockChangesModel->method = $stockChangesRepository->method;

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

}
