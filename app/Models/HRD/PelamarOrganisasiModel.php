<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PelamarOrganisasiModel extends Model
{
    protected $table = "hrd_recr_organisasi";
    protected $fillable = ["id_pelamar", "nama_organisasi", "posisi", "mulai_tahun", "sampai_tahun"];
}
