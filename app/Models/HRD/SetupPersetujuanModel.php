<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class SetupPersetujuanModel extends Model
{
    protected $table = "hrd_setup_persetujuan";
    protected $fillable = ['id', 'modul', 'lvl_pengajuan', 'lvl_persetujuan', 'status'];
}
