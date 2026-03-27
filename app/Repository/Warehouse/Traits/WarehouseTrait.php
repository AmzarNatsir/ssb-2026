<?php

namespace App\Repository\Warehouse\Traits;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WarehouseTrait
{

  public function editable()
  {
    return $this->status === static::CURRENT_STATUS;
  }

  public function getCurrentStatus()
  {
    return static::CURRENT_STATUS;
  }

  public function getDateCreationAttribute()
  {
    return date('d.m.Y', strtotime($this->created_at));
  }

  public function numberFormat($number)
  {
    return number_format($number, 2, '.', ',');
  }

  public function created_user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }

  public function updated_user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'updated_by', 'id');
  }

  public function getFormattedDate($columnName = null)
  {
    if (!$columnName) {
      return;
    }
    return date('d.m.Y', strtotime($this->$columnName));
  }

  public function increaseSparePartStock()
  {
    foreach ($this->details as $detail) {
      $detail->sparepart->increaseStock($detail->qty, $this);
    }
  }

  public function decreaseSparePartStock()
  {
    foreach ($this->details as $detail) {
      $detail->sparepart->decreaseStock($detail->qty, $this);
    }
  }

  public function numbering($number)
  {
    switch ($number) {
      case $number < 10:
        return '0000' . $number;
        break;
      case $number < 100:
        return '000' . $number;
        break;
      case $number < 1000:
        return '00' . $number;
        break;
      case $number < 10000:
        return '0' . $number;
        break;
      default:
        return $number;
        break;
    }
  }

  public function getNumberPrefix()
  {
    return static::NUMBER_PREFIX;
  }

  public function generateNumber(): string
  {
    $lastNumber = $this->getLastNumber() + 1;

    return $this->extractPrefix() . $this->numbering($lastNumber);
  }

  public function getLastNumber(): int
  {
    $lastNumber =  $this->selectRaw("CAST(SUBSTR(number,-5,5) as UNSIGNED) AS latest_number")
      ->whereRaw("number like '" . $this->extractPrefix() . "%'")
      ->orderByRaw('CAST(SUBSTR(number,-5,5) as UNSIGNED) DESC')
      ->limit(1)
      ->get('latest_number');

    return $lastNumber->count() ? $lastNumber->first()->latest_number : 0;
  }

  public function extractPrefix()
  {
    $prefix = $this->getNumberPrefix();

    $prefix = preg_replace('/{year}/', date('Y'), $prefix);
    $prefix = preg_replace('/{month}/', date('m'), $prefix);

    return $prefix;
  }

  public function increaseFuelTankStock(Model $reference, $amount = 0)
  {
    if ($this instanceof \App\Models\Warehouse\FuelTank) {
      $fuelTank = $this;
    } else {
      $fuelTank = $this->fuel_tank;
    }

    $originalStock = $fuelTank->stock;

    $fuelTank->stock = $fuelTank->stock + $amount;

    $fuelTank->save();

    \App\Repository\Warehouse\FuelChanges::captureChanges([
      'reference_id' => $reference->id,
      'reference' => get_class($reference),
      'stock' => $originalStock,
      'updated_stock' => $fuelTank->stock,
      'fuel_tank_id' => $fuelTank->id,
      'method' => \App\Models\Warehouse\FuelChanges::INCREASE
    ]);
  }

  public function decreaseFuelTankStock(Model $reference, $amount = 0)
  {
    if ($this instanceof \App\Models\Warehouse\FuelTank) {
      $fuelTank = $this;
    } else {
      $fuelTank = $this->fuel_tank;
    }

    $originalStock = $fuelTank->stock;

    $fuelTank->stock = abs($fuelTank->stock - $amount);

    $fuelTank->save();

    \App\Repository\Warehouse\FuelChanges::captureChanges([
      'reference_id' => $reference->id,
      'reference' => get_class($reference),
      'stock' => $originalStock,
      'updated_stock' => $fuelTank->stock,
      'fuel_tank_id' => $fuelTank->id,
      'method' => \App\Models\Warehouse\FuelChanges::DEDUCT
    ]);
  }

  public function increaseFuelTruckStock($reference, $amount)
  {
    if ($this instanceof \App\Models\Warehouse\FuelTruck) {
      $fuelTruck = $this;
    } else {
      $fuelTruck = $this->fuel_truck;
    }

    $originalStock = $fuelTruck->stock;
    $fuelTruck->stock = abs($fuelTruck->stock + $amount);

    $fuelTruck->save();

    \App\Models\Warehouse\FuelTruckHistory::capture($reference, $fuelTruck, $originalStock, 'increase');
  }

  public function decreaseFuelTruckStock($reference, $amount)
  {
    if ($this instanceof \App\Models\Warehouse\FuelTruck) {
      $fuelTruck = $this;
    } else {
      $fuelTruck = $this->fuel_truck;
    }

    $originalStock = $fuelTruck->stock;
    $fuelTruck->stock = abs($fuelTruck->stock - $amount);

    $fuelTruck->save();

    \App\Models\Warehouse\FuelTruckHistory::capture($reference, $fuelTruck, $originalStock, 'deduct');
  }

  public function scopeFilterDateRange($q, $dateStart, $dateEnd, $column = 'created_at')
  {
    $dateStart = date('Y-m-d', strtotime($dateStart));
    $dateEnd = date('Y-m-d', strtotime($dateEnd));

    return $q->whereBetween($column, [$dateStart, $dateEnd]);
  }
}


