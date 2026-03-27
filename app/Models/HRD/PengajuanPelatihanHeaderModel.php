<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PengajuanPelatihanHeaderModel extends Model
{
    protected $table = "hrd_pengajuan_pelatihan_h";
    protected $fillable = [
        'tahun',
        'deskripsi',
        'approval_key',
        'status_pengajuan',
        'current_approval_id',
        'is_draft',
        'diajukan_oleh'
    ];

    public function get_detail()
    {
        return $this->hasMany('App\Models\HRD\PengajuanPelatihanDetailModel', 'id_head');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }

    public function get_diajukan_oleh()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'diajukan_oleh', 'id');
    }
}
