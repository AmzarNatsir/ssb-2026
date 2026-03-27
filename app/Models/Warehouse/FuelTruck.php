<?php

namespace App\Models\Warehouse;

use App\Models\Workshop\Equipment;
use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelTruck extends Model
{
    use SoftDeletes, WarehouseTrait;

    protected $table = 'fuel_truck';
    protected $fillable = [
        'equipment_id',
        'number',
        'capacity',
        'stock',
        'created_by',
        'updated_by'
    ];

    public function save(array $options = [])
    {
        if ($user = auth()->user()) {
            if (!$this->created_by) {
                $this->created_by = $user->id;
            }
            $this->updated_by = $user->id;
        }

        return parent::save($options);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
    }

    public function fuelTruckHistory()
    {
        return $this->morphMany(FuelTruckHistory::class, 'fuelTruckHistory', 'reference_type', 'reference_id');
    }
}
