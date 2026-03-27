<?php

namespace App\Observers;

use App\Models\Warehouse\PurchasingOrder;

class PurchasingOrderObserver
{
    /**
     * Handle the purchasing order "created" event.
     *
     * @param  \App\PurchasingOrder  $purchasingOrder
     * @return void
     */
    public function created(PurchasingOrder $purchasingOrder)
    {
        $purchasingOrder->updatePurchasingComparison();
    }

    /**
     * Handle the purchasing order "updated" event.
     *
     * @param  \App\PurchasingOrder  $purchasingOrder
     * @return void
     */
    public function updated(PurchasingOrder $purchasingOrder)
    {
        //
    }

    /**
     * Handle the purchasing order "deleted" event.
     *
     * @param  \App\PurchasingOrder  $purchasingOrder
     * @return void
     */
    public function deleted(PurchasingOrder $purchasingOrder)
    {
        $purchasingOrder->updatePurchasingComparison(\App\Models\Warehouse\PurchasingComparison::CURRENT_STATUS);
    }

    /**
     * Handle the purchasing order "restored" event.
     *
     * @param  \App\PurchasingOrder  $purchasingOrder
     * @return void
     */
    public function restored(PurchasingOrder $purchasingOrder)
    {
        //
    }

    /**
     * Handle the purchasing order "force deleted" event.
     *
     * @param  \App\PurchasingOrder  $purchasingOrder
     * @return void
     */
    public function forceDeleted(PurchasingOrder $purchasingOrder)
    {
        //
    }
}
