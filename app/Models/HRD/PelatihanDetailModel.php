<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PelatihanDetailModel extends Model
{
    protected $table = "hrd_pelatihan_d";
    protected $fillable = [
        'id_head',
        'id_karyawan',
        'biaya_investasi',
        'tujuan_pelatihan_pasca',
        'uraian_materi_pasca',
        'tindak_lanjut_pasca',
        'dampak_pasca',
        'penutup_pasca',
        'evidence_pasca',
        'pasca'
    ];

    public function get_karyawan()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }
}
