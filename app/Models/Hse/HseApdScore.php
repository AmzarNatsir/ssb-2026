<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseApdScore extends Model
{

    protected $table = "hse_apd_score";
    protected $fillable = [
        "no_dokumen",
        "lokasi_kerja",
        "id_karyawan",
        "item_penilaian",
        "id_apd",
        "score_apd",
        "score_apd_nilai",
        "score_pemahaman_kta",
        "score_pemahaman_tta",
        "score_perawatan_apd",
        "total_score"
    ];

    protected $casts = [
        'item_penilaian' => 'array'
    ];

    public function apd(){
        return $this->belongsTo(\App\Models\Hse\MstApd::class, 'id_apd');
    }

    public function karyawan(){
        return $this->belongsTo(\App\Models\HRD\KaryawanModel::class, 'id_karyawan');
    }
}
