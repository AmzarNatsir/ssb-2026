<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class FulfillmentUnit extends Model
{
    protected $table = "fulfillment_unit";    
    protected $fillable = [
        'project_id',
        'user_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function details()
    {
        return $this->hasMany(FulfillmentUnitDetail::class);
    }

    public function user(){
    	return $this->belongsTo('\App\User', 'user_id');
    }
}
