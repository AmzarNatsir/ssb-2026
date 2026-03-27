<?php

namespace App\Models\Warehouse;

use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelTank extends Model
{
    use SoftDeletes, WarehouseTrait;

    protected $table = 'fuel_tank';

    protected $fillable = [
        'number',
        'capacity',
        'stock',
        'created_by',
        'updated_by'
    ];

    public function save(array $options = [])
    {
        $userId = auth()->user()->id;

        if (!$this->created_by) {
            $this->created_by = $userId;
        }

        $this->updated_by = $userId;

        return parent::save($options);
    }
}
