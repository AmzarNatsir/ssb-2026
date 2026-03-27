<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PengalamanKerjaModel extends Model
{
    protected $table = "hrd_karyawan_pengalaman_kerja";
    protected $fillable = ['id_karyawan', 'nm_perusahaan', 'posisi', 'alamat', 'mulai_tahun', 'sampai_tahun'];

    public function get_profil()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }
}
