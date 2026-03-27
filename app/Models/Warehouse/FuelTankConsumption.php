<?php

namespace App\Models\Warehouse;

use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelTankConsumption extends Model
{
    use SoftDeletes, WarehouseTrait;

    const PAGE_LIMIT = 50;
    const NUMBER_PREFIX = 'FTC.{year}.{month}.';

    protected $table = 'fuel_tank_consumption';
    protected $fillable = [
        'date',
        'number',
        'fuel_tank_id',
        'reference_type',
        'reference_id',
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

    public function fuel_tank()
    {
        return $this->belongsTo(FuelTank::class, 'fuel_tank_id', 'id');
    }

    public function fuelTankConsumption()
    {
        return $this->morphTo('', 'reference_type', 'reference_id');
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
