<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class SetupBPJSModel extends Model
{
    protected $table = "hrd_set_bpjs";
    protected $fillable = ["jht_karyawan", "jht_perusahaan", "jkk_karyawan", "jkk_perusahaan", "jkm_karyawan", "jkm_perusahaan", "jp_karyawan", "jp_perusahaan", "bpjsks_karyawan", "bpjsks_perusahaan"];
}
