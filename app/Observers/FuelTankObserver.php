<?php

namespace App\Observers;

use App\Models\Warehouse\FuelTank;
use App\Repository\Warehouse\FuelChanges;

class FuelTankObserver
{
    /**
     * Handle the fuel tank "created" event.
     *
     * @param  \App\Models\Warehouse\FuelTank  $fuelTank
     * @return void
     */
    public function created(FuelTank $fuelTank)
    {
        // FuelChanges::captureChanges([
        //     'method' => \App\Models\Warehouse\FuelChanges::CREATED,
        //     'fuel_tank_id' => $fuelTank->id,
        //     'stock' => $fuelTank->stock,
        //     'updated_stock' => $fuelTank->stock,
        //     'referece_id' => $fuelTank->id,
        //     'reference' => get_class($fuelTank),
        // ]);
    }

    /**
     * Handle the fuel tank "updated" event.
     *
     * @param  \App\Models\Warehouse\FuelTank  $fuelTank
     * @return void
     */
    public function updated(FuelTank $fuelTank)
    {
        // if ($fuelTank->stock != $fuelTank->getOriginal('stock')) {
        //     if ($fuelTank->stock > $fuelTank->getOriginal('stock')) {
    
        //         $method = \App\Models\Warehouse\FuelChanges::INCREASE;
    
        //     } elseif ($fuelTank->stock < $fuelTank->getOriginal('stock')) {
    
        //         $method = \App\Models\Warehouse\FuelChanges::DEDUCT;
        //     } else {
        //         $method = '';
        //     }
            
        //     FuelChanges::captureChanges([
        //         'method' => $method,
        //         'fuel_tank_id' => $fuelTank->id,
        //         'stock' => $fuelTank->getOriginal('stock'),
        //         'updated_stock' => $fuelTank->stock,
        //         'referece_id' => $fuelTank->id,
        //         'reference' => get_class($fuelTank),
        //     ]);
        // }

    }

    /**
     * Handle the fuel tank "deleted" event.
     *
     * @param  \App\Models\Warehouse\FuelTank  $fuelTank
     * @return void
     */
    public function deleted(FuelTank $fuelTank)
    {
        //
    }

    /**
     * Handle the fuel tank "restored" event.
     *
     * @param  \App\Models\Warehouse\FuelTank  $fuelTank
     * @return void
     */
    public function restored(FuelTank $fuelTank)
    {
        //
    }

    /**
     * Handle the fuel tank "force deleted" event.
     *
     * @param  \App\Models\Warehouse\FuelTank  $fuelTank
     * @return void
     */
    public function forceDeleted(FuelTank $fuelTank)
    {
        //
    }
}
