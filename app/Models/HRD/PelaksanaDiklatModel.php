<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PelaksanaDiklatModel extends Model
{
    protected $table = "mst_hrd_pelaksana_diklat";
    protected $fillable = ['nama_lembaga', 'alamat', 'no_telepon', 'nama_email', 'kontak_person'];
}
