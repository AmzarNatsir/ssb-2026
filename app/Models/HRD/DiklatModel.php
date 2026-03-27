<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class DiklatModel extends Model
{
    protected $table = "hrd_diklat";
    protected $fillable = ['id_karyawan', 'id_pelaksana', 'nama_diklat', 'tgl_mulai', 'tgl_selesai', 'biaya', 'tempat', 'status', 'nilai'];

    public function profil_karyawan(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function profil_pelaksana(){
        return $this->belongsTo('App\Models\HRD\PelaksanaDiklatModel', 'id_pelaksana', 'id');
    }
}
