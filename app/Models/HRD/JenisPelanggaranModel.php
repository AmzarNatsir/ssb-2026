<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaranModel extends Model
{
    protected $table = "mst_hrd_jenis_pelanggaran";
    protected $fillable = [
        'jenis_pelanggaran',
        'status'
    ];
}
