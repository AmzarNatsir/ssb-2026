<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class MstHsePerusahaanAngkutan extends Model
{
    protected $table = "mst_hse_perusahaan_angkutan";
    protected $fillable = ['nama','nama_pimpinan','alamat','is_active','email','nomor_kontak'];
}
