<?php

namespace App\Models\Warehouse;

use App\Models\HRD\KaryawanModel;
use App\Repository\Warehouse\Traits\WarehouseTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receiving extends Model
{
    use SoftDeletes, WarehouseTrait;

    const PAGE_LIMIT = 20;

    const CURRENT_STATUS = 4;

    const IS_ISSUED_IMMEDIATELY = 1;

    protected $table = 'receiving';

    protected $fillable = [
        'number',
        'purchasing_order_id',
        'supplier_id',
        'invoice_number',
        'remarks',
        'issued_immediately',
        'received_by',
        'approved_by',
        'created_by',
        'received_at'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(ReceivingDetail::class, 'receiving_id', 'id');
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

    public function received_user(): BelongsTo
    {
        return $this->belongsTo(KaryawanModel::class, 'received_by', 'id');
    }

    public function approved_user(): BelongsTo
    {
        return $this->belongsTo(KaryawanModel::class, 'approved_by', 'id');
    }

    public function updatePurchasingOrder($status = null)
    {
        $purchasingOrder = $this->purchasing_order;

        if ($status) {
            $purchasingOrder->status = $status;
        } else {
            $purchasingOrder->status = static::CURRENT_STATUS;
        }

        return $purchasingOrder->save();
    }

    public function syncPurchasingOrder()
    {
        $purchasingOder = $this->purchasing_order;
        $purchasingOrderDetail = $purchasingOder->details;


        $details = $this->details;


        foreach ($purchasingOrderDetail as $podetail) {
            // count how many qty received and on po
            $itemCount = $podetail->receiving_detail->sum('qty') - $podetail->qty;

            if ($itemCount === 0) {
                $podetail->update(['status' => PurchasingOrderDetail::STATUS_RECEIVED]);
            } else {
                $podetail->update(['status' => PurchasingOrderDetail::STATUS_NOT_RECEIVED]);
            }
        }

        $purchasingOder->updatePurchasingOrderStatus();
    }

    public function editable()
    {
        // receiving is editable and deleteable befre 24 hours after created or is issued immediately
        return $this->issued_immediately == static::IS_ISSUED_IMMEDIATELY || (strtotime(now()) - strtotime($this->created_at)) < 86400;
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'reference_id', 'id');
    }
}
