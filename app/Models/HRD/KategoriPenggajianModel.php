<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class KategoriPenggajianModel extends Model
{
    protected $table = "mst_hrd_kategori_penggajian";
    protected $fillable = ['kat_penggajian', 'status'];
}
