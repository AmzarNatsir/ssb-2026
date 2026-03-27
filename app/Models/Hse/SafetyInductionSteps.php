<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class SafetyInductionSteps extends Model
{
    protected $table = "safety_induction_steps";
    protected $fillable = [
        'safety_inductions_id',
        'name',
        'docnumber',
        'file_types_id',
        'filename',        
        'updated_by'
    ];
}
