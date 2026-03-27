<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class KPISasaranModel extends Model
{
    protected $table = "mst_hrd_kpi_sasaran_strategi";
    protected $fillable = [
        'sasaran_strategi',
        'active'
    ];
}
