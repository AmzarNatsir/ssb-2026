<?php

namespace App\Warehouse\Contracts;

interface MasterData {

    public $model;

    public function getAll();

    public function store(array $attributes);

}