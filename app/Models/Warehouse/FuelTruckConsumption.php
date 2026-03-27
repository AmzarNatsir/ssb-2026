<?php

namespace App\Models\Warehouse;

use App\Models\Workshop\Equipment;
use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelTruckConsumption extends Model
{
    use SoftDeletes, WarehouseTrait;

    const NUMBER_PREFIX = 'FTRC.{year}.{month}.';
    const PAGE_LIMIT = 50;

    protected $table = 'fuel_truck_consumption';
    protected $fillable = [
        'date',
        'number',
        'fuel_truck_id',
        'equipment',
        'amount',
        'current_stock',
        'description',
        'created_by',
        'updated_by',
        'hm',
        'km'
    ];

    public function save(array $options = [])
    {
        if ($user = auth()->user()) {
            if (!$this->created_by) {
                $this->created_by = $user->id;
            }
            $this->updated_by = $user->id;
        }

        if (!$this->number) {
            $this->number = $this->generateNumber();
        }

        return parent::save($options);
    }

    public function fuel_truck()
    {
        return $this->belongsTo(FuelTruck::class, 'fuel_truck_id', 'id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
    }

    public function fuelTruckHistory()
    {
        return $this->morphMany(FuelTruckHistory::class, 'fuelTruckHistory', 'reference_type', 'reference_id');
    }

    public function editable()
    {
        return (strtotime(now()) - strtotime($this->created_at)) < 86400;
    }
}
