<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseSla extends Model
{
    protected $table = "hse_sla";
    protected $fillable = [
        'form_number',
        'location',
        'audit_date',
        'audit_start_time',
        'audit_end_time',
        'audit_teams',
        'audit_actionables',
        'audit_findings',
        'safety_behaviors',
        'status',
        'created_by',
    ];

    protected $casts = [
        'audit_teams' => 'array',
        'audit_actionables' => 'array',
        'audit_findings' => 'array',
        'safety_behaviors' => 'array',
    ];
}
