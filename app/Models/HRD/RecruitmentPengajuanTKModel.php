<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class RecruitmentPengajuanTKModel extends Model
{
    protected $table = "hrd_recr_pengajuan_tk";
    protected $fillable = [
        'tanggal_pengajuan',
        'id_departemen',
        'id_jabatan',
        'jumlah_orang',
        'tanggal_dibutuhkan',
        'alasan_permintaan',
        'jenkel',
        'umur_min',
        'umur_maks',
        'pendidikan',
        'keahlian_khusus',
        'pengalaman',
        'kemampuan_bahasa_ing',
        'kemampuan_bahasa_ind',
        'kemampuan_bahasa_lain',
        'kepribadian',
        'catatan',
        'id_approval_al',
        'status_approval_al',
        'tanggal_approval_al',
        'desk_approval_al',
        'id_approval_hrd',
        'status_approval_hrd',
        'tanggal_approval_hrd',
        'desk_approval_hrd',
        'id_approval_atl',
        'status_approval_atl',
        'tanggal_approval_atl',
        'desk_approval_atl',
        'user_id',
        'approval_key',
        'status_pengajuan',
        'current_approval_id',
        'is_draft'
    ];

    public function get_departemen()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'id_departemen', 'id');
    }

    public function get_jabatan()
    {
        return $this->belongsTo('App\Models\HRD\JabatanModel', 'id_jabatan', 'id');
    }

    public function user_al()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_approval_al', 'id');
    }

    public function user_atl()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_approval_atl','id');
    }

    public function user_hrd()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_approval_hrd','id');
    }

    public function user_create()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }

}
