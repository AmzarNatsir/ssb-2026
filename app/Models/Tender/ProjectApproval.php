<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProjectApproval extends Model
{
    protected $table = "project_approval";
    protected $fillable = [
    	'project_id',
    	'user_id',
    	'hasil',
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
    	return $this->belongsTo('App\Models\HRD\KaryawanModel', 'user_id', 'id');
    }
}
