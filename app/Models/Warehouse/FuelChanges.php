<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class FuelChanges extends Model
{

  protected $table = 'fuel_changes';

  protected $fillable = [
    'module',
    'fuel_tank_id',
    'reference_id',
    'reference',
    'stock',
    'method',
    'updated_stock',
    'user_id'
  ];

  const DEDUCT = 'deduct';
  const INCREASE = 'increase';
  const CREATED = 'created';

  public function save(array $options = [])
  {
    if (!$this->user_id) {
      $this->user_id = auth()->user()->id;
    }

    return parent::save($options);
  }

  public function getReferenceObjectAttribute()
  {
    return $reference = $this->reference::find($this->reference_id);
  }

  public function getDescriptionAttribute()
  {

    if (str_contains(strtolower($this->module), 'fuelreceiving')) {
      if (str_contains(strtolower($this->module), 'destroy')) {
        return "Delete Fuel Receiving Number ".FuelReceiving::withTrashed()->find($this->reference_id)?->number;
      }
      return "<a target='_blank' href='" . route('warehouse.fuel-receiving.print', $this->reference_id) . "'>" . $this->referenceObject?->number . " (Receiving) </a>";
    } elseif (str_contains(strtolower($this->module), 'fueltankconsumption')) {
      if (str_contains(strtolower($this->module), 'destroy')) {
        return "Delete Fuel Receiving Number".FuelTankConsumption::withTrashed()->find($this->reference_id)?->number;
      } else
        return "<a target='_blank' href='" . route('warehouse.issued.print', $this->reference_id) . "'>" . $this->referenceObject?->number . " (Fuel Tank Consumption)</a>";
    } else {
      return 'Master Data Fuel Tank';
    }
  }
}
