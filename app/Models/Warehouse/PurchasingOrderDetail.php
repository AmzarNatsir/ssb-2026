<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchasingOrderDetail extends Model
{

    const STATUS_NOT_RECEIVED = 0;
    const STATUS_RECEIVED = 1;
    const STATUS_RETURNED = 2;

    protected $table = 'purchasing_order_detail';

    protected $fillable = [
        'purchasing_order_id',
        'part_id',
        'qty',
        'price',
        'discount',
        'remarks',
        'status'
    ];

    public $timestamps = false;

    public function purchasingOrder(): BelongsTo
    {
        return $this->belongsTo(PurchasingOrder::class, 'purchasing_order_id', 'id');
    }

    public function sparepart(): HasOne
    {
        return $this->hasOne(SparePart::class,'id' ,'part_id');
    }

    public function received()
    {
        return $this->where('status', static::STATUS_RECEIVED);
    }

    public function returned()
    {
        return $this->where('status', static::STATUS_RETURNED);
    }

    public function not_received()
    {
        return $this->where('status', static::STATUS_NOT_RECEIVED);
    }

    public function getSubtotalAttribute()
    {
        return ($this->qty * $this->price) - $this->discount;
    }

    public function receiving_detail(): HasMany
    {
        return $this->hasMany(ReceivingDetail::class, 'purchasing_order_detail_id', 'id');
    }

    public function part_return_detail(): HasMany
    {
        return $this->hasMany(PartReturnDetail::class, 'purchasing_order_detail_id', 'id');
    }

}