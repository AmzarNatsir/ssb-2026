<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class ResignModel extends Model
{
    protected $table = "hrd_resign";
    protected $fillable = [
        'id_karyawan',
        'tgl_eff_resign',
        'alasan_resign',
        'approval_key',
        'create_by',
        'current_approval_id',
        'is_draft',
        'sts_pengajuan',
        'cara_keluar',
        'nomor_skk',
        'tgl_skk',
        'file_surat_resign',
        'created_at',
        'updated_at'
    ];

    public function getKaryawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'id_karyawan', 'id');
    }
    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
}
