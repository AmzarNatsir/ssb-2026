<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class PreAnalystApproval extends Model
{
    // pre_analyst_approval
    protected $table = "pre_analyst_approval";
    protected $fillable = [
    	'user_id',
    	'project_id',
    	'is_approve',    	
    	'note'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function project(){
    	return $this->belongsTo(Project::class, 'project_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function files()
    {
        return $this->belongsToMany('App\Models\Tender\Files','pre_analyst_file')
            ->withPivot('created_at', 'updated_at');
    }
}
