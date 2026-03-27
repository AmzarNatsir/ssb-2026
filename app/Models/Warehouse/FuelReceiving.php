<?php

namespace App\Models\Warehouse;

use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelReceiving extends Model
{

    use SoftDeletes, WarehouseTrait;

    const PAGE_LIMIT = 20;

    protected $table = 'fuel_receiving';

    protected $fillable = [
        'number',
        'supplier_id',
        'fuel_tank_id',
        'vehicle_number',
        'driver_name',
        'invoice_number',
        'invoice_amount',
        'real_amount',
        'difference',
        'remarks',
        'created_by',
        'received_at'
    ];

    public function save(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }

        return parent::save($options);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function fuel_tank(): BelongsTo
    {
        return $this->belongsTo(FuelTank::class, 'fuel_tank_id', 'id');
    }

    public function editable()
    {
        // issued is editable and deleteable befre 24 hours after created
        return (strtotime(now()) - strtotime($this->created_at)) < 86400;
    }

    public function increaseFuelTankStock()
    {

        $fuelTank = $this->fuel_tank;

        $originalStock = $fuelTank->stock;

        $fuelTank->stock = $fuelTank->stock + $this->real_amount;

        $fuelTank->save();

        \App\Repository\Warehouse\FuelChanges::captureChanges([
            'reference_id' => $this->id,
            'reference' => get_class($this),
            'stock' => $originalStock,
            'updated_stock' => $fuelTank->stock,
            'fuel_tank_id' => $fuelTank->id,
            'method' => \App\Models\Warehouse\FuelChanges::INCREASE
        ]);
    }

    public function decreaseFuelTankStock()
    {

        $fuelTank = $this->fuel_tank;

        $originalStock = $fuelTank->stock;

        $fuelTank->stock = abs($fuelTank->stock - $this->real_amount);

        $fuelTank->save();

        \App\Repository\Warehouse\FuelChanges::captureChanges([
            'reference_id' => $this->id,
            'reference' => get_class($this),
            'stock' => $originalStock,
            'updated_stock' => $fuelTank->stock,
            'fuel_tank_id' => $fuelTank->id,
            'method' => \App\Models\Warehouse\FuelChanges::DEDUCT
        ]);
    }
}
