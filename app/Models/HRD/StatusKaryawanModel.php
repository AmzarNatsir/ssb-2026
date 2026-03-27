<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class StatusKaryawanModel extends Model
{
    protected $table = "mst_hrd_status_karyawan";
    protected $fillable = ["nm_status", "keterangan", "status"];
}
