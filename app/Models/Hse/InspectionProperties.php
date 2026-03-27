<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class InspectionProperties extends Model
{
    protected $table = "inspection_properties";
    protected $fillable = [
        'inspection_item_id',
        'inspection_properties_input_id',
        'name',
        'dataset',
        'mandatory',
        'incl_field_keterangan'
    ];

    public function item(){
        return $this->belongsTo(InspectionItem::class, 'inspection_item_id');
    }

    public function input(){
        return $this->belongsTo(InspectionPropertiesInput::class, 'inspection_properties_input_id');
    }
}
