<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIPeriodikLampiranModel extends Model
{
    use HasFactory;
    protected $table = "hrd_kpi_periodik_lampiran";
    protected $fillable = [
        'id_head',
        'id_detail_kpi',
        'keterangan',
        'file_lampiran'
    ];

    public function kpiPeriodik()
    {
        return $this->belongsTo(KPIPeriodikModel::class, 'id_head', 'id');
    }
}
