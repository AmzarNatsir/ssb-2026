<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class RecruitmentPersetujuanModel extends Model
{
    protected $table = 'hrd_recr_persetujuan';
    protected $fillable = [
        'id_pelamar', 'hasil', 'keterangan', 'user_id', 'tanggal_persetujuan', 'level'
    ];

    public function get_profil_pelamar()
    {
        return $this->belongsTo('App\Models\HRD\PelamarModel', 'id_pelamar', 'id');
    }

    public function user_by()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel','user_id','id');
    }
}
