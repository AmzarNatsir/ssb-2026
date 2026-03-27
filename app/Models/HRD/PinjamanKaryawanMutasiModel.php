<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PinjamanKaryawanMutasiModel extends Model
{
    protected $table = "hrd_pinjaman_karyawan_mutasi";
    protected $fillable = [
        "id_head",
        "tanggal",
        "nominal",
        "status",
        "bayar_aktif",
        "bukti_bayar"
    ];

}
