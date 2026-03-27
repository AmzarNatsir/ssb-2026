<?php

namespace App\Models\Workshop\MasterData;

use App\Models\Warehouse\SparePart;
use Illuminate\Database\Eloquent\Model;

class WorkshopPartOrder extends Model
{
    protected $table = 'workshop_part_order';
    protected $fillable = [
        'type_id',
        'type',
        'part_id',
        'qty',
        'description',
        'status'
    ];

    public $timestamps = false;

    public function partable()
    {
        return $this->morphTo();
    }

    public function sparepart()
    {
        return $this->belongsTo(SparePart::class, 'part_id', 'id');
    }
}
