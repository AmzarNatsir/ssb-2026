<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionChecklistItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'order'];

    public function inspectionChecklistGroup(){
        return $this->belongsTo(InspectionChecklistGroup::class);
    }

    public function scopeSortByOrder($query){
        return $query->orderBy('order', 'asc');
    }
}
