<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class LemburModel extends Model
{
    protected $table = "hrd_lembur";
    protected $fillable = [
        'id_karyawan',
        'tgl_pengajuan',
        'jam_mulai',
        'jam_selesai',
        'total_jam',
        'deskripsi_pekerjaan',
        'keterangan',
        'status_pengajuan',
        'approval_key',
        'current_approval_id',
        'file_surat_perintah_lembur'
    ];

    public function get_profil_karyawan()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
}
