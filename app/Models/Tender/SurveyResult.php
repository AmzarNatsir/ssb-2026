<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SurveyResult extends Model
{
    protected $table = "survey_result";
    protected $fillable = [
        'survey_id',
        'segment',
        'lng',
        'lat',
        'note',
        'surveyor_id'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}
