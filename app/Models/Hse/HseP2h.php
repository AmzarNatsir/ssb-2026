<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseP2h extends Model
{
    protected $table = "hse_p2h";
    protected $fillable = [
        "jenis_p2h",
        "kategori_kendaraan",
        "no_unit",
        "tgl_inspeksi",
        "hm_awal",
        "hm_akhir",
        "lokasi",
        "pelaksana",
        "penanggung_jawab_unit",
        "safety_officer",
        "form_file",
        "penggantian_alat_keselamatan",
        "created_by",
        "updated_by"
    ];

    protected $cast = [
        "kategori_kendaraan",
        "pelaksana",
        "penanggung_jawab_unit",
        "safety_officer",
        "penggantian_alat_keselamatan"
    ];
}
