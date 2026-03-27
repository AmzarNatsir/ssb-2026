<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseApdOrder extends Model
{
    protected $table = "hse_apd_order";
    protected $fillable = [
        'tanggal_order',
        'id_apd',
        'id_pengorder',
        'no_order',
        'qty'
    ];

    public function apd(){
        return $this->belongsTo(\App\Models\Hse\MstApd::class, 'id_apd');
    }

    public function karyawan(){
        return $this->belongsTo(\App\Models\HRD\KaryawanModel::class, 'id_pengorder');
    }
}
