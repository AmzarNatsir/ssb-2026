<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PotonganGajiKaryawanModel extends Model
{
    protected $table = "hrd_potongan_karyawan";
    protected $fillable = [
        'id_karyawan',
        'id_potongan',
        'jumlah'
    ];

    public function get_karyawan()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_item_potongan()
    {
        return $this->belongsTo('App\Models\HRD\PotonganGajiModel', 'id_potongan', 'id');
    }

}
