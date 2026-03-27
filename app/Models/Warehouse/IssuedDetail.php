<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IssuedDetail extends Model
{
    protected $table = 'issued_detail';

    public $timestamps = false;

    protected $fillable = [
        'issued_id',
        'part_id',
        'qty',
        'remarks'
    ];

    public function issued(): BelongsTo
    {
        return $this->belongsTo(Issued::class, 'issued_id', 'id');
    }

    public function sparepart(): HasOne
    {
        return $this->hasOne(SparePart::class,'id' ,'part_id');
    }

}
