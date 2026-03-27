<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class KPIPerspektifModel extends Model
{
    protected $table = "mst_hrd_kpi_perspektif";
    protected $fillable = [
        'perspektif',
        'active'
    ];
}
