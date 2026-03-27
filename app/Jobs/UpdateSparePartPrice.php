<?php

namespace App\Jobs;

use App\Models\Warehouse\PurchasingOrder;
use App\Models\Warehouse\SparePart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSparePartPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $purchasingOrder;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($purchasingOrderId)
    {
        $this->purchasingOrder = PurchasingOrder::findOrFail($purchasingOrderId);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->purchasingOrder->details->each(function($detail){
            $detail->sparepart->update(['price' => $detail->price]);
        });
    }
}
