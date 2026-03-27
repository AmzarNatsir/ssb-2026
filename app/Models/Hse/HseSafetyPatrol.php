<?php

namespace App\models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseSafetyPatrol extends Model
{
    protected $table = "hse_safety_patrol";
    protected $fillable = ["tgl_patroli", "hse_officer", "locations", "status"];

    protected $casts = [
        'hse_officer' => 'array',
        'locations' => 'array',
    ];
}
