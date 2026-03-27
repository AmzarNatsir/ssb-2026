<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class JenisDokumenKaryawanModel extends Model
{
    protected $table = "mst_hrd_jenis_dokumen_karyawan";
    protected $fillable = ['nm_dokumen', 'status', 'karyawan', 'pelamar'];
}
