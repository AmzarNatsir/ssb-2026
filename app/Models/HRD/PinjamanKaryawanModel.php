<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PinjamanKaryawanModel extends Model
{
    protected $table = "hrd_pinjaman_karyawan";
    protected $fillable = [
        'id_karyawan',
        'tgl_pengajuan',
        'kategori',
        'alasan_pengajuan',
        'nominal_apply',
        'nominal_acc',
        'tenor_apply',
        'tenor_acc',
        'angsuran',
        'status_pengajuan',
        'aktif',
        'approval_key',
        'current_approval_id',
        'is_draft',
        'nomor_pinjaman'
    ];

    public function getKaryawan()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function getDokumen()
    {
        return $this->hasMany('App\Models\HRD\PinjamanKaryawanDokumenModel', 'id_head', 'id');
    }

    public function getMutasi()
    {
        return $this->hasMany('App\Models\HRD\PinjamanKaryawanMutasiModel', 'id_head', 'id');
    }

    public function getListPembayaran()
    {
        return $this->hasMany('App\Models\HRD\PembayaranPinjamanKaryawanModel', 'id_head', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
}
