<?php

namespace App\Warehouse\Services;

class MasterData 
{
    public $model;

    public function __construct(string $model)
    {
        $this->model = new $model;
    }


    public function getAll()
    {
        return $this->model->all();
    }

    public function store(array $attributes)
    {
        $masterData = new $this->model;

        $masterData = $this->model->fill($attributes);

        return $masterData->save();
    }

}
