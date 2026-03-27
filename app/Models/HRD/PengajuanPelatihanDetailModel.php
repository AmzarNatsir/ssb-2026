<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PengajuanPelatihanDetailModel extends Model
{
    protected $table = "hrd_pengajuan_pelatihan_d";
    protected $fillable = [
        'id_head',
        'id_pelatihan'
    ];

    public function getPelatihan()
    {
        return $this->belongsTo('App\Models\HRD\PelatihanHeaderModel', 'id_pelatihan', 'id');
    }
}
