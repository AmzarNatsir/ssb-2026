<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class SafetyInduction extends Model
{
    protected $table = "safety_inductions";
    protected $fillable = [
        'conduct_date',
        'employee_id',
        'approve_by',
        'created_by',
        'updated_by'
    ];

    public function steps()
    {
        return $this->hasMany(SafetyInductionSteps::class, 'safety_inductions_id');
    }

    public function employee()
    {
        return $this->hasOne(\App\User::class, 'id', 'employee_id');
    }

    public function hse_officer()
    {
        return $this->hasOne(\App\User::class, 'id', 'created_by');
    }
}
