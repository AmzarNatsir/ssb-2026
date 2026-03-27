<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Survey extends Model
{
    protected $table = "survey";
    protected $fillable = [
        'surveyor_id',
        'surveyor_group',
        'date',
        'notes',
        'summary_notes',
        'assign_by',
        'project_id'
    ];
    protected $dates = ['date'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function surveyor()
    {
        return $this->belongsTo(User::class, 'surveyor_id', 'id');
    }

    public function results()
    {
        return $this->hasMany(SurveyResult::class);
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assignBy(){
        return $this->hasOne(User::class, 'id', 'assign_by');
    }

    public function files()
    {
        return $this->belongsToMany('App\Models\Tender\Files','survey_file')
            ->withPivot('created_at', 'updated_at');
    }

    public function scopeSurveyHasCompleted($query)
    {
        return $query->whereNotNull('completed_by');
    }

    public function preAnalystCompleted(){
        return $this->project()->preAnalystApproval->id;
    }


}
