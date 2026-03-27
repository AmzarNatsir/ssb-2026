<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Boq extends Model
{
    protected $table = "boq";
    protected $fillable = [
        'project_id',
        'created_by',
        'updated_by'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function project()
    {
    	return $this->belongsTo(Project::class,'project_id');// , 'project_id', 'id'
    }

    public function detail()
    {
    	return $this->hasMany(BoqDetail::class,'boq_id');
    }

}
