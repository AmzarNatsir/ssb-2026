<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionChecklistGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','order'];

    public function inspectionChecklistItems(){
        return $this->hasMany(InspectionChecklistItem::class);
    }

    public function scopeSortByOrder($query){
        return $query->orderBy('order', 'asc');
    }
}
