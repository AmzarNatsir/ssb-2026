<?php

namespace App\Observers;

use App\Models\Warehouse\ReceivingDetail;

class ReceivingDetailObserver
{
    /**
     * Handle the receiving detail "created" event.
     *
     * @param  \App\Models\Warehouse\ReceivingDetail  $receivingDetail
     * @return void
     */
    public function created(ReceivingDetail $receivingDetail)
    {
        $receivingDetail->receiving->syncPurchasingOrder();
        $receivingDetail->receiving->updatePurchasingOrder();
    }

    /**
     * Handle the receiving detail "updated" event.
     *
     * @param  \App\Models\Warehouse\ReceivingDetail  $receivingDetail
     * @return void
     */
    public function updated(ReceivingDetail $receivingDetail)
    {
        //
    }

    /**
     * Handle the receiving detail "deleted" event.
     *
     * @param  \App\Models\Warehouse\ReceivingDetail  $receivingDetail
     * @return void
     */
    public function deleted(ReceivingDetail $receivingDetail)
    {
        //
    }

    /**
     * Handle the receiving detail "restored" event.
     *
     * @param  \App\Models\Warehouse\ReceivingDetail  $receivingDetail
     * @return void
     */
    public function restored(ReceivingDetail $receivingDetail)
    {
        //
    }

    /**
     * Handle the receiving detail "force deleted" event.
     *
     * @param  \App\Models\Warehouse\ReceivingDetail  $receivingDetail
     * @return void
     */
    public function forceDeleted(ReceivingDetail $receivingDetail)
    {
        //
    }
}
