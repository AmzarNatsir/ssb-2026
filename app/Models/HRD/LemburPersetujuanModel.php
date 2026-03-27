<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class LemburPersetujuanModel extends Model
{
    protected $table = "hrd_lembur_persetujuan";
    protected $fillable = [
        'id_lembur',
        'level',
        'id_pejabat',
        'status_persetujuan',
        'tgl_persetujuan',
        'ket_persetujuan'
    ];
}
