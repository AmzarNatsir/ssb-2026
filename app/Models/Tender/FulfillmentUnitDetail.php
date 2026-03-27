<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workshop\Equipment;


class FulfillmentUnitDetail extends Model
{
    protected $table = "fulfillment_unit_detail";    
    protected $fillable = [
        'fulfillment_unit_id',        
        'equipment_id',
    ];

    public function unit()
    {
        return $this->belongsTo(FulfillmentUnit::class);
    }

    public function equipment(){
        return $this->belongsTo(Equipment::class);
    }
}
