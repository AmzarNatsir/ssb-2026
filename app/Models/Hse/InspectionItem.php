<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class InspectionItem extends Model
{
    protected $table = "inspection_item";
    protected $fillable = ['name','label'];

    public function properties(){
        return $this->hasMany(InspectionProperties::class, 'inspection_item_id', 'id');
    }

    public function equipment_category(){
        return $this->hasOne(\App\Models\Workshop\EquipmentCategory::class, 'id','equipment_category');
    }
}
