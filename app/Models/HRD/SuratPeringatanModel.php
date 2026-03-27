<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class SuratPeringatanModel extends Model
{
    protected $table = "hrd_sp";
    protected $fillable = ['id_karyawan', 'no_sp', 'tgl_sp', 'id_jenis_sp_disetujui', 'uraian_pelanggaran', 'id_pengajuan', 'tgl_pengajuan', 'id_jenis_sp_pengajuan', 'id_persetujuan', 'sts_persetujuan', 'tgl_persetujuan', 'ket_persetujuan', 'sts_pengajuan', 'id_user', 'id_departemen', 'approval_key', 'current_approval_id', 'is_draft', 'create_by'];

    public function profil_karyawan(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_master_jenis_sp_diajukan()
    {
        return $this->belongsTo("App\Models\HRD\JenisSPModel", 'id_jenis_sp_pengajuan', 'id');
    }
    public function get_master_jenis_sp_disetujui()
    {
        return $this->belongsTo("App\Models\HRD\JenisSPModel", 'id_jenis_sp_disetujui', 'id');
    }

    public function profil_atasan_langsung(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_pengajuan', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
    public function get_diajukan_oleh(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'create_by', 'id');
    }

    public function get_penonaktifan_sp()
    {
        return $this->hasMany(SPNonAktifModel::class, 'id_sp', 'id');
    }
}
