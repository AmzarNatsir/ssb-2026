<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PelamarDokumenModel extends Model
{
    protected $table = "hrd_recr_dokumen";
    protected $fillable = ["id_pelamar", "id_dokumen", "file_dokumen", "path_file"];

    public function get_master_dokumen()
    {
        return $this->belongsTo("App\Models\HRD\JenisDokumenKaryawanModel", "id_dokumen", "id");
    }
    
}
