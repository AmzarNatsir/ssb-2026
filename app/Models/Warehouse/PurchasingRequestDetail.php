<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchasingRequestDetail extends Model
{
    protected $table = 'purchasing_request_detail';

    protected $fillable = [
        'purchasing_request_id',
        'part_id',
        'qty',
        'price',
        'eta',
        'remarks'
    ];

    public $timestamps = false;

    public function purchasingRequest(): BelongsTo
    {
        return $this->belongsTo(PurchasingRequestDetail::class, 'purchasing_request_id','id');
    }

    public function sparepart(): HasOne
    {
        return $this->hasOne(SparePart::class,'id' ,'part_id');
    }
}
