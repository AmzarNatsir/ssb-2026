<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class KPISatuanModel extends Model
{
    protected $table = "mst_hrd_kpi_satuan";
    protected $fillable = [
        'satuan_kpi',
        'active'
    ];
}
