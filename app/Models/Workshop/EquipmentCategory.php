<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCategory extends Model
{
    use SoftDeletes;
    protected $table = 'equipment_category';
    protected $fillable = ['name', 'description'];
    public $timestamps = false;

    public function equipments()
    {
        return $this->hasMany(Equipment::class,'equipment_category_id');
    }
}
