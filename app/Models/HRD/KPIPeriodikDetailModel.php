<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIPeriodikDetailModel extends Model
{
    use HasFactory;
    protected $table = "hrd_kpi_periodik_detail";
    protected $fillable = [
        'id_head',
        'id_kpi',
        'nama_kpi',
        'tipe',
        'satuan',
        'bobot',
        'target',
        'realisasi',
        'skor_akhir',
        'nilai_kpi'
    ];

    public function getKPIPeriodik()
    {
        return $this->belongsTo(KPIPeriodikModel::class, 'id_head', 'id');
    }

    public function getKPIMaster()
    {
        return $this->belongsTo(KPIMasterModel::class, 'id_kpi', 'id');
    }
}
