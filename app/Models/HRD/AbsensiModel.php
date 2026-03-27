<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class AbsensiModel extends Model
{
    protected $table = "hrd_absensi";
    protected $fillable = [
        'id_departemen',
        'id_finger',
        'tanggal',
        'jam',
        'status',
        'lokasi_id',
        'user_id',
        'dhuhur', //y atau t
        'ashar', // y atau t
        'nik_lama'
    ];

}
