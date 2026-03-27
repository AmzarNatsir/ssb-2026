<?php

namespace App\Models\Warehouse;

use App\Models\Workshop\WorkOrder;
use App\Repository\Warehouse\Traits\WarehouseTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingOrder extends Model
{
    use SoftDeletes, WarehouseTrait;

    const PAGE_LIMIT = 20;

    const CURRENT_STATUS = 3;

    const PURCHASING_ORDER_STATUS_INCOMPLETE = 0;
    const PURCHASING_ORDER_STATUS_COMPLETE = 1;

    protected $table = 'purchasing_order';

    protected $fillable = [
        'number',
        'purchasing_comparison_id',
        'reference_id',
        'supplier_id',
        'subtotal',
        'total_discount',
        'ppn',
        'remarks',
        'additional_expense',
        'grand_total',
        'send_date',
        'approved_by',
        'created_by',
        'status',
        'purchasing_order_status'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(PurchasingOrderDetail::class, 'purchasing_order_id', 'id');
    }

    public function purchasing_comparison(): BelongsTo
    {
        return $this->belongsTo(PurchasingComparison::class, 'purchasing_comparison_id', 'id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function updatePurchasingComparison($status = null )
    {
        $purchasingComparison = $this->purchasing_comparison;

        if ($status) {
            $purchasingComparison->status = $status;
        } else {
            $purchasingComparison->status = static::CURRENT_STATUS;
        }
        
        return $purchasingComparison->save();
    }

    public function save(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }

        return parent::save($options);
    }

    public function updatePurchasingOrderStatus()
    {
        $details = $this->details;

        $detailsCompleted = 0 ;

        foreach ($details as $detail) {
            if ($detail->status == PurchasingOrderDetail::STATUS_RECEIVED) {
                $detailsCompleted++;
            }
        }

        if ($detailsCompleted == $details->count()) {
            $this->purchasing_order_status = static::PURCHASING_ORDER_STATUS_COMPLETE ;
        } else {
            $this->purchasing_order_status = static::PURCHASING_ORDER_STATUS_INCOMPLETE ;
        }

        $this->save();
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'reference_id', 'id');
    }


}
