<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusDetailModel extends Model
{
    use HasFactory;
    protected $table = "hrd_bonus_header";
    protected $fillabel = [
        "id_karyawan",
        "bulan",
        "tahun",
        "gaji_pokok",
        "bonus",
        "lembur",
    ];
}
