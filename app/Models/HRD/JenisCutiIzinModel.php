<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class JenisCutiIzinModel extends Model
{
    protected $table = "mst_hrd_jenis_cuti_izin";
    protected $fillable = ["jenis_ci", "nm_jenis_ci", "lama_cuti", "keterangan", "status"];
}
