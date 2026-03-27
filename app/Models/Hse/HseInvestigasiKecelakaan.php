<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseInvestigasiKecelakaan extends Model
{
    protected $table = "hse_investigasi_kecelakaan";
    protected $fillable = [
        "no_dokumen",
        "no_revisi",
        "no_form",
        "user_id",
        "fakta_investigasi",
        "jenis_kejadian",
        "rincian_bagian_tubuh",
        "rincian_accident_lingkungan",
        "rincian_kerusakan_alat",
        "ketua_tim",
        "anggota_tim",
        "saksi"
    ];

    protected $casts = [
        'jenis_kejadian' => 'array',
        'rincian_bagian_tubuh' => 'array',
        'rincian_accident_lingkungan' => 'array',
        'rincian_kerusakan_alat' => 'array',
        'ketua_tim' => 'array',
        'anggota_tim' => 'array',
        'saksi' => 'array'
    ];

    public function bak(){
        return $this->hasOne('App\Models\Hse\HseBak', 'id_investigasi_kecelakaan');
    }
}
