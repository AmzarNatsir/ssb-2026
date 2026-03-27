<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class KPITipeModel extends Model
{
    protected $table = "mst_hrd_kpi_tipe";
    protected $fillable = [
        'tipe_kpi',
        'active'
    ];
}
