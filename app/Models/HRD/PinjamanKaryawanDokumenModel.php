<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PinjamanKaryawanDokumenModel extends Model
{
    protected $table = "hrd_pinjaman_karyawan_dokumen";
    protected $fillable = [
        'id_head',
        'file_dokumen',
        'keterangan'
    ];
}
