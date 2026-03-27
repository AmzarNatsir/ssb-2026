<?php

namespace App\Observers;

use App\Models\Warehouse\SparePart;
use App\Repository\Warehouse\StockChanges;

class SparePartObserver
{
    /**
     * Handle the spare part "created" event.
     *
     * @param  \App\Models\Warehouse\SparePart  $sparePart
     * @return void
     */
    public function created(SparePart $sparePart)
    {
        StockChanges::captureChanges([
            'spare_part' => $sparePart,
            'reference' => get_class($sparePart), 
            'method' =>  \App\Models\Warehouse\StockChanges::INCREASE, 
            'stock' => 0, 
            'updated_stock' => $sparePart->stock,
            'reference_id' => $sparePart->id
        ]);
    }

    /**
     * Handle the spare part "updated" event.
     *
     * @param  \App\Models\Warehouse\SparePart  $sparePart
     * @return void
     */
    public function updated(SparePart $sparePart)
    {

        // if ($sparePart->stock != $sparePart->getOriginal('stock')) {
            
        //     if ($sparePart->stock > $sparePart->getOriginal('stock')) {
    
        //         $method = \App\Models\Warehouse\StockChanges::INCREASE;
    
        //     } elseif ($sparePart->stock < $sparePart->getOriginal('stock')) {
    
        //         $method = \App\Models\Warehouse\StockChanges::DEDUCT;
        //     }
    
        //     if ($sparePart->stock != $sparePart->getOriginal('stock')) {
        //         StockChanges::captureChanges([
        //             'spare_part' => $sparePart,
        //             'reference' => $sparePart, 
        //             'method' =>  $method, 
        //             'stock' => $sparePart->getOriginal('stock'), 
        //             'updated_stock' => $sparePart->stock
        //         ]);
        //     }

        // }


    }

    /**
     * Handle the spare part "deleted" event.
     *
     * @param  \App\Models\Warehouse\SparePart  $sparePart
     * @return void
     */
    public function deleted(SparePart $sparePart)
    {
        //
    }

    /**
     * Handle the spare part "restored" event.
     *
     * @param  \App\Models\Warehouse\SparePart  $sparePart
     * @return void
     */
    public function restored(SparePart $sparePart)
    {
        //
    }

    /**
     * Handle the spare part "force deleted" event.
     *
     * @param  \App\Models\Warehouse\SparePart  $sparePart
     * @return void
     */
    public function forceDeleted(SparePart $sparePart)
    {
        //
    }
}
