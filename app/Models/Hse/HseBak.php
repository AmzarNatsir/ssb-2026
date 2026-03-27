<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseBak extends Model
{
    protected $table = "hse_bak";
    protected $fillable = [
        "no_form",
        "nama_site",
        "tgl_kejadian",
        "jam_kejadian",
        "id_karyawan",
        "user_id",
        "kronologis"
    ];

    protected $casts = [
        'id_karyawan' => 'array'
    ];

    public function investigasi(){
        return $this->belongsTo('App\Models\Hse\HseInvestigasiKecelakaan', 'id_investigasi_kecelakaan');
    }
}
