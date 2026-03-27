<?php

namespace App\Models\Warehouse;

use App\Models\Workshop\WorkOrder;
use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingComparison extends Model
{
    use SoftDeletes,WarehouseTrait;

    const PAGE_LIMIT = 20;

    const CURRENT_STATUS = 2;

    protected $table = 'purchasing_comparison';

    protected $fillable = [
        'number',
        'purchasing_request_id',
        'reference_id',
        'supplier_ids',
        'status',
        'approved_by',
        'created_by'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(PurchasingComparisonDetail::class,'purchasing_comparison_id', 'id');
    }

    public function save(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }

        return parent::save($options);
    }

    public function getSupplierNameAttribute()
    {
        return \App\Models\Warehouse\Supplier::select('name')->whereIn('id', explode(',',$this->supplier_ids))->get();
        
    }

    public function purchasing_request(): BelongsTo
    {
        return $this->belongsTo(PurchasingRequest::class, 'purchasing_request_id', 'id');
    }

    public function updatePurchasingRequest($status = null )
    {
        $purchasingRequest = $this->purchasing_request;

        if ($status) {
            $purchasingRequest->status = $status;
        } else {
            $purchasingRequest->status = static::CURRENT_STATUS;
        }
        
        return $purchasingRequest->save();
        
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'reference_id', 'id');
    }
    

}
