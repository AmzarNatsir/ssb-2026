<?php

namespace App\Models\Warehouse;

use App\Models\Workshop\WorkOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Repository\Warehouse\Traits\WarehouseTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasingRequest extends Model
{
    use SoftDeletes,WarehouseTrait;

    const PAGE_LIMIT = 20;

    const CURRENT_STATUS = 1;

    const PURCHASING_TYPE = [
        1 => 'WORKSHOP',
        2 => 'WAREHOUSE',
        3 => 'DIRECT'
    ];

    protected $table = 'purchasing_request';

    protected $fillable = [
        'number',
        'purchasing_type',
        'reference_id',
        'remarks',
        'status',
        'total_qty',
        'total_price',
        'created_by'
    ];


    public function save(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }

        return parent::save($options);
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchasingRequestDetail::class,'purchasing_request_id', 'id');
    }

    public function getTypeAttribute()
    {
        return self::PURCHASING_TYPE[$this->purchasing_type];
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'reference_id', 'id');
    }

}
