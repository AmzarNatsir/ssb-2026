<?php

namespace App\Warehouse\Contracts;

interface MasterData {


    public function getAll();

    public function store(array $attributes);

}