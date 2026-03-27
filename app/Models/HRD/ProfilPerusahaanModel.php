<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class ProfilPerusahaanModel extends Model
{
    protected $table = "mst_hrd_profil_perusahaan";
    protected $fillable = ["nm_perusahaan", "alamat", "kelurahan", "kecamatan", "kabupaten", "provinsi", "no_telpon", "no_fax", "nm_emaili", "nm_pimpinan", "logo_perusahaan"];

}
