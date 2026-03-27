<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchasingComparisonDetail extends Model
{
    protected $table = 'purchasing_comparison_detail';

    protected $fillable = [
        'purchasing_comparison_id',
        'supplier_id',
        'part_id',
        'qty',
        'price',
        'eta',
        'remarks'
    ];

    public $timestamps = false;

    public function purchasingComparison(): BelongsTo
    {
        return $this->belongsTo(PurchasingComparisonDetail::class, 'purchasing_comparison_id','id');
    }

    public function sparepart(): HasOne
    {
        return $this->hasOne(SparePart::class,'id' ,'part_id');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class,'id' ,'supplier_id');
    }
}
