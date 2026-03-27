<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;

class EquipmentStatus extends Model
{
    protected $table = 'equipment_status';
    protected $fillable = ['name'];
    public $timestamps = true;
}
