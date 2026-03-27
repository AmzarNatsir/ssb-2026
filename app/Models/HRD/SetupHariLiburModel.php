<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class SetupHariLiburModel extends Model
{
    protected $table = "hrd_setup_hari_libur";
    protected $fillable = ['tahun', 'tanggal', 'keterangan'];
}
