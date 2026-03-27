<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class IzinModel extends Model
{
    protected $table = "hrd_izin";
    protected $fillable = ['id_karyawan', 'id_jenis_izin', 'tgl_awal', 'tgl_akhir', 'ket_izin', 'id_user', 'tgl_pengajuan', 'sts_pengajuan', 'id_persetujuan', 'sts_persetujuan', 'tgl_persetujuan', 'ket_persetujuan', 'jumlah_hari', 'id_atasan', 'tgl_appr_atasan', 'sts_appr_atasan', 'ket_appr_atasan', 'id_departemen', 'approval_key', 'status_pengajuan', 'current_approval_id', 'is_draft'];

    public function profil_karyawan(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_jenis_izin()
    {
        return $this->belongsTo('App\Models\HRD\JenisCutiIzinModel', 'id_jenis_izin', 'id');
    }

    public function get_profil_atasan_langsung()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_atasan', 'id');
    }

    public function get_profil_hrd()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_persetujuan', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
}
