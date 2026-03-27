<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReceivingDetail extends Model
{
    protected $table = 'receiving_detail';

    public $timestamps = false;

    protected $fillable = [
        'part_id',
        'purchasing_order_detail_id',
        'receiving_id',
        'qty'
    ];

    public function receiving(): BelongsTo
    {
        return $this->belongsTo(Receiving::class, 'receiving_id', 'id');
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
