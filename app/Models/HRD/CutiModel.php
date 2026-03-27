<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class CutiModel extends Model
{
    protected $table = "hrd_cuti";
    protected $fillable = ['id_karyawan', 'id_jenis_cuti', 'tgl_awal', 'tgl_akhir', 'tgl_masuk', 'jumlah_hari', 'ket_cuti', 'id_user', 'tgl_pengajuan', 'sts_pengajuan', 'id_persetujuan', 'sts_persetujuan', 'tgl_persetujuan', 'ket_persetujuan', 'id_atasan', 'tgl_appr_atasan', 'sts_appr_atasan', 'ket_appr_atasan', 'id_pengganti', 'id_departemen', 'approval_key', 'current_approval_id', 'is_draft', 'jumlah_quota', 'quota_terpakai', 'sisa_quota', 'nomor_surat', 'tanggal_surat'];

    public function profil_karyawan(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_jenis_cuti()
    {
        return $this->belongsTo('App\Models\HRD\JenisCutiIzinModel', 'id_jenis_cuti', 'id');
    }

    public function get_karyawan_pengganti()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_pengganti', 'id');
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
