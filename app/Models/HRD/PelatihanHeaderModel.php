<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PelatihanHeaderModel extends Model
{
    protected $table = "hrd_pelatihan_h";
    protected $fillable = [
        'nomor',
        'tanggal',
        'id_pelatihan',
        'id_pelaksana',
        'hari_awal',
        'hari_sampai',
        'tanggal_awal',
        'tanggal_sampai',
        'pukul_awal',
        'pukul_sampai',
        'tempat_pelaksanaan',
        'id_ttd',
        'alasan_pengajuan',
        'status_pelatihan',
        'diajukan_by',
        'departemen_by',
        'id_approval',
        'tgl_approval',
        'catatam_approval',
        'total_investasi',
        'approval_key',
        'status_pengajuan',
        'current_approval_id',
        'is_draft',
        'kategori',
        'nama_pelatihan',
        'nama_vendor',
        'kontak_vendor',
        'durasi',
        'kompetensi',
        'investasi_per_orang'
    ];

    public function get_nama_pelatihan()
    {
        return $this->belongsTo('App\Models\HRD\MasterPelatihanModel', 'id_pelatihan', 'id');
    }
    public function get_pelaksana()
    {
        return $this->belongsTo('App\Models\HRD\PelaksanaDiklatModel', 'id_pelaksana', 'id');
    }

    public function get_detail()
    {
        return $this->belongsTo('App\Models\HRD\PelatihanDetailModel', 'id_head', 'id');
    }

    public function get_peserta()
    {
        return $this->hasMany('App\Models\HRD\PelatihanDetailModel', 'id_head', 'id');
    }

    public function get_departemen()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'departemen_by', 'id');
    }

    public function get_karyawan_ttd()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_ttd', 'id');
    }
    public function get_karyawan_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_approval', 'id');
    }
}
