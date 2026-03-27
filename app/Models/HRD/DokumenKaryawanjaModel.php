<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class DokumenKaryawanjaModel extends Model
{
    protected $table = "hrd_karyawan_dokumen";
    protected $fillable = ['id_karyawan', 'id_dokumen', 'file_dokumen'];
    
    public function get_profil()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_jenis_dokumen()
    {
        return $this->belongsTo('App\Models\HRD\JenisDokumenKaryawanModel', 'id_dokumen', 'id');
    }
}
