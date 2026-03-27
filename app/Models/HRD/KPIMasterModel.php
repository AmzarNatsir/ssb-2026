<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIMasterModel extends Model
{
    use HasFactory;
    protected $table = "mst_hrd_kpi";
    protected $fillable = [
        'id_departemen',
        'id_tipe',
        'id_satuan',
        'nama_kpi',
        'formula_hitung',
        'data_pendukung',
        'bobot_kpi'
    ];

    public function tipeKPI()
    {
        return $this->belongsTo(KPITipeModel::class, 'id_tipe', 'id');
    }

    public function satuanKPI()
    {
        return $this->belongsTo(KPISatuanModel::class, 'id_satuan', 'id');
    }

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'id_departemen', 'id');
    }
}
