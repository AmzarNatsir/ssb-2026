<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class KPIModel extends Model
{
    protected $table = "hrd_kpi";
    protected $fillable = [
        'id_departemen',
        'id_perspektif',
        'id_sasaran',
        'id_tipe',
        'id_satuan',
        'nama_kpi',
        'formula_hitung',
        'laporan_data_pendukung',
        'bobot_kpi'
    ];

    public function Perspektif()
    {
        return $this->belongsTo(KPIPerspektifModel::class, 'id_perspektif', 'id');
    }

    public function SasaranStrategi()
    {
        return $this->belongsTo(KPISasaranModel::class, 'id_sasaran', 'id');
    }

    public function TipeKPI()
    {
        return $this->belongsTo(KPITipeModel::class, 'id_tipe', 'id');
    }

    public function SatuanKPI()
    {
        return $this->belongsTo(KPISatuanModel::class, 'id_satuan', 'id');
    }
}
