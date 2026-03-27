<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class ApdKeluar extends Model
{
    protected $table = "hse_apd_keluar";
    protected $fillable = [
        'no_register',
        'id_project',
        'id_apd',
        'id_karyawan_peminjam',
        'id_karyawan_menyerahkan',
        'qty_out',
        'tanggal_keluar',
        'keterangan',
    ];

    public function project(){
        return $this->belongsTo(\App\Models\Tender\Project::class, 'id_project');
    }

    public function karyawan(){
        return $this->belongsTo(\App\Models\HRD\KaryawanModel::class, 'id_karyawan_peminjam');
    }

    public function apd(){
        return $this->belongsTo(\App\Models\Hse\MstApd::class, 'id_apd');
    }
}
