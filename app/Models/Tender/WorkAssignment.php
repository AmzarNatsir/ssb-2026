<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkAssignment extends Model
{
    protected $table = "work_assignment";    
    protected $fillable = [
        'project_id',
        'user_id',
        'assignment_number',
        'assignment_date',
        'assignment_amount'
    ];

    // public function getAssignmentDateAttribute($value)
    // {        
    //     return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    // }

    public function getCreatedAtAttribute($value)
    {        
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }
}
