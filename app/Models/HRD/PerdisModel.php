<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PerdisModel extends Model
{
    protected $table = "hrd_perdis";
    protected $fillable = ['id_karyawan', 'no_perdis', 'tgl_perdis', 'maksud_tujuan', 'tgl_berangkat', 'tgl_kembali', 'id_uangsaku', 'id_fasilitas', 'ket_perdis', 'id_user', 'tgl_pengajuan', 'sts_pengajuan', 'id_persetujuan', 'sts_persetujuan', 'tgl_persetujuan', 'ket_persetujuan', 'id_departemen', 'tujuan', 'diajukan_oleh', 'id_approval_al', 'status_approval_al', 'tanggal_approval_al', 'desk_approval_al', 'approval_key', 'current_approval_id', 'is_draft'];

    public function get_diajukan_oleh(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'diajukan_oleh', 'id');
    }

    public function get_profil(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_master_uang_saku()
    {
        return $this->belongsTo('App\Models\HRD\UangSakuPerdisModel', 'id_uangsaku', 'id');
    }

    public function get_master_fasilitas_perdis()
    {
        return $this->belongsTo('App\Models\HRD\FasilitasPerdisModel', 'id_fasilitas', 'id');
    }

    public function get_fasilitas()
    {
        return $this->hasMany('App\Models\HRD\PerdisFasilitasModel', 'id_perdis', 'id');
    }

    public function get_approver_al()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_approval_al', 'id');
    }

    public function get_approver()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_persetujuan', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
}
