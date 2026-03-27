<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PotonganGajiModel extends Model
{
    protected $table = "mst_hrd_potongan_gaji";
    protected $fillable = [
        'nama_potongan',
        'status'
    ];
    
}
