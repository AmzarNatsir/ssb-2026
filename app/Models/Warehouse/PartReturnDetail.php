<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PartReturnDetail extends Model
{
    protected $table = 'part_return_detail';

    public $timestamps = false;

    protected $fillable = [
        'part_return_id',
        'purchasing_order_detail_id',
        'part_id',
        'qty',
        'price'
    ];

    public function part_return(): BelongsTo
    {
        return $this->belongsTo(PartReturn::class, 'part_return_id', 'id');
    }

    public function sparepart(): HasOne
    {
        return $this->hasOne(SparePart::class,'id' ,'part_id');
    }

    public function purchasing_order_detail(): BelongsTo 
    {
        return $this->belongsTo(PurchasingOrderDetail::class, 'purchasing_order_detail_id', 'id');
    }
}
