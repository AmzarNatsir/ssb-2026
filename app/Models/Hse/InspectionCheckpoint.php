<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class InspectionCheckpoint extends Model
{
    protected $table = "inspection_checkpoint";    
    protected $fillable = ['inspection_id','inspection_item_id','properties'];
    protected $casts = [
        'properties' => 'array'
    ];    

    public function checkpointItems()
    {
        return $this->hasMany(InspectionItem::class, 'id', 'inspection_item_id');
    }
}
