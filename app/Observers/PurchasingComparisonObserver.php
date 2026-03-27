<?php

namespace App\Observers;

use App\Models\Warehouse\PurchasingComparison;

class PurchasingComparisonObserver
{
    /**
     * Handle the purchasing comparison "created" event.
     *
     * @param  \App\PurchasingComparison  $purchasingComparison
     * @return void
     */
    public function created(PurchasingComparison $purchasingComparison)
    {
        $purchasingComparison->updatePurchasingRequest();
    }

    /**
     * Handle the purchasing comparison "updated" event.
     *
     * @param  \App\PurchasingComparison  $purchasingComparison
     * @return void
     */
    public function updated(PurchasingComparison $purchasingComparison)
    {
        //
    }

    /**
     * Handle the purchasing comparison "deleted" event.
     *
     * @param  \App\PurchasingComparison  $purchasingComparison
     * @return void
     */
    public function deleted(PurchasingComparison $purchasingComparison)
    {
        $purchasingComparison->updatePurchasingRequest(\App\Models\Warehouse\PurchasingRequest::CURRENT_STATUS);
    }

    /**
     * Handle the purchasing comparison "restored" event.
     *
     * @param  \App\PurchasingComparison  $purchasingComparison
     * @return void
     */
    public function restored(PurchasingComparison $purchasingComparison)
    {
        //
    }

    /**
     * Handle the purchasing comparison "force deleted" event.
     *
     * @param  \App\PurchasingComparison  $purchasingComparison
     * @return void
     */
    public function forceDeleted(PurchasingComparison $purchasingComparison)
    {
        //
    }
}
