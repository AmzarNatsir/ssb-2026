<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class SuratTeguranModel extends Model
{
    protected $table = "hrd_surat_teguran";
    protected $fillable = ['id_karyawan', 'tanggal_kejadian', 'waktu_kejadian', 'tempat_kejadian', 'id_jenis_pelanggaran', 'akibat', 'tindakan', 'rekomendasi', 'komentar_pelanggar', 'tanggal_pengajuan', 'approval_key', 'status_pengajuan', 'current_approval_id', 'is_draft', 'create_by', 'no_st', 'tgl_st', 'sp_lama_active', 'sp_mulai_active', 'sp_akhir_active'];

    public function get_karyawan()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }
    public function get_jenis_pelanggaran()
    {
        return $this->belongsTo('App\Models\HRD\JenisPelanggaranModel', 'id_jenis_pelanggaran', 'id');
    }
    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
    public function get_diajukan_oleh(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'create_by', 'id');
    }
}
