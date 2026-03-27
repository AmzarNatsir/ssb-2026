<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPinjamanKaryawanModel extends Model
{
    use HasFactory;
    protected $table = "hrd_pinjaman_karyawan_pembayaran";
    protected $fillable = [
        "id_head",
        "tanggal",
        "nominal",
        "id_user",
        "bukti_bayar",
    ];
}
