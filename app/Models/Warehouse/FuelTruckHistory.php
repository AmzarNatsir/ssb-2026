<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class FuelTruckHistory extends Model
{
    protected $table = 'fuel_truck_history';
    protected $fillable = ['fuel_truck_id', 'module', 'reference_type', 'reference_id', 'method', 'stock', 'updated_stock', 'user_id'];

    const DEDUCT = 'deduct';
    const INCREASE = 'increase';
    const CREATED = 'created';

    public function save(array $options = [])
    {
        if (auth()->user()) {
            if (!$this->user_id) {
                $this->user_id = auth()->user()->id;
            }
        }

        return parent::save($options);
    }

    public function getReferenceObjectAttribute()
    {
        return $reference = $this->reference::findOrFail($this->reference_id);
    }

    public function fuelTruckHistory()
    {
        return $this->morphTo('', 'reference_type', 'reference_id')->withTrashed();
    }

    public static function capture(Model $type, FuelTruck $fuelTruck, $currentStock = 0, $method = '')
    {
        $fuelTruckHistory = new static();
        $fuelTruckHistory->module = get_class($type);
        if ($method) {
            $fuelTruckHistory->method = $method;
        } else {
            $fuelTruckHistory->method = $currentStock > $fuelTruck->stock ? 'deduct' : 'increase';
        }
        $fuelTruckHistory->fuel_truck_id = $fuelTruck->id;
        $fuelTruckHistory->stock = $currentStock;
        $fuelTruckHistory->updated_stock = $fuelTruck->stock;

        $type->fuelTruckHistory()->save($fuelTruckHistory);
    }

    public function getDescriptionAttribute()
    {
        if (str_contains(strtolower($this->module), 'fueltankconsumption')) {
            if ($this->fuelTruckHistory->trashed()) {
                return $this->fuelTruckHistory->number . " (Fuel Tank Consumption) DELETED";
            }
            return "<a target='_blank' href='" . route('warehouse.fuel-receiving.print', $this->reference_id) . "'>" . $this->fuelTruckHistory->number . " (Fuel Tank Consumption) </a>";
            return "<a target='_blank' href='" . route('warehouse.issued.print', $this->reference_id) . "'>" . $this->referenceObject->number . " (Issued)</a>";
        } elseif (str_contains(strtolower($this->module), 'fueltruckconsumption')) {
            if ($this->fuelTruckHistory->trashed()) {
                return $this->fuelTruckHistory->number . " (Fuel Truck Consumption) DELETED";
            }
            return "<a target='_blank' href='" . route('warehouse.fuel-receiving.print', $this->reference_id) . "'>" . $this->fuelTruckHistory->number . " (Fuel Truck Consumption) </a>";
            return "<a target='_blank' href='" . route('warehouse.issued.print', $this->reference_id) . "'>" . $this->referenceObject->number . " (Issued)</a>";
        } else {
            return 'Master Data Fuel Truck';
        }
    }
}
