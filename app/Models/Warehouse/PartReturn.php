<?php

namespace App\Models\Warehouse;

use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartReturn extends Model
{
    use SoftDeletes, WarehouseTrait;

    const PAGE_LIMIT = 20;

    const CURRENT_STATUS = 4;

    const RETURN_STATUS_INCOMPLETE = 0;

    const RETURN_STATUS_COMPLETE = 1;

    protected $table = 'part_return';

    protected $fillable = [
        'number',
        'supplier_id', 
        'purchasing_order_id',
        'reference_id',
        'subtotal',
        'ppn',
        'grand_total',
        'status',
        'return_status',
        'created_by'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(PartReturnDetail::class, 'part_return_id', 'id');
    }

    public function purchasing_order(): BelongsTo
    {
        return $this->belongsTo(PurchasingOrder::class, 'purchasing_order_id', 'id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function save(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }

        return parent::save($options);
    }

    public function syncPurchasingOrder( $reverse = false )
    {
        $purchasingOder = $this->purchasing_order;
        $purchasingOrderDetail = $purchasingOder->details;

        $details = $this->details;

        foreach ($purchasingOrderDetail->whereIn('id', $details->pluck('purchasing_order_detail_id')->toArray() ) as $podetail) {
            
            if ($reverse) {
                $podetail->update(['status' => PurchasingOrderDetail::STATUS_NOT_RECEIVED]);
            } else {
                $podetail->update(['status' => PurchasingOrderDetail::STATUS_RETURNED]);
            }
            
        }

        $purchasingOder->updatePurchasingOrderStatus();

    }

    public function updatePurchasingOrder($status = null )
    {
        $purchasingOrder = $this->purchasing_order;

        if ($status) {
            $purchasingOrder->status = $status;
        } else {
            $purchasingOrder->status = Receiving::CURRENT_STATUS;
            $purchasingOrder->purchasing_order_status = PurchasingOrder::PURCHASING_ORDER_STATUS_INCOMPLETE;
        }
        
        return $purchasingOrder->save();
    }

    public function release()
    {
        $purchasingOrder = $this->purchasing_order;

        foreach ($purchasingOrder->details as $key => $podetail) {
            $podetail->update(['status' => PurchasingOrderDetail::STATUS_NOT_RECEIVED]);
        }

        $purchasingOrder->purchasing_order_status = PurchasingOrder::PURCHASING_ORDER_STATUS_INCOMPLETE;

        $this->return_status = static::RETURN_STATUS_COMPLETE;
        
        $this->save();

        return true;
    }

    public function editable()
    {
        return $this->return_status === static::RETURN_STATUS_INCOMPLETE;
    }

}
