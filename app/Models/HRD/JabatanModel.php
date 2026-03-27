<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JabatanModel extends Model
{
    protected $table = "mst_hrd_jabatan";
    protected $fillable = ["id_level", "id_divisi", "id_dept", "id_subdept", "id_gakom", "id_gakor", "nm_jabatan", "status", 'file_jobdesc', 'file_pkwt'];

    public function mst_level_jabatan()
    {
        return $this->belongsTo("App\Models\HRD\LevelJabatanModel", "id_level", "id");
    }
    public function mst_divisi()
    {
        return $this->belongsTo("App\Models\HRD\DivisiModel", "id_divisi", "id");
    }
    public function mst_departemen()
    {
        return $this->belongsTo("App\Models\HRD\DepartemenModel", "id_dept", "id");
    }
    public function mst_subdepartemen()
    {
        return $this->belongsTo("App\Models\HRD\SubDepartemenModel", "id_subdept", "id");
    }
    public function get_jabatan_atasan_langsung()
    {
        return $this->belongsTo('App\Models\HRD\JabatanModel', 'id_gakom', 'id');
    }

    public function get_id_gakom($id)
    {
        return DB::table("mst_hrd_jabatan")
                    ->where("mst_hrd_jabatan.id", $id)
                    ->get()->first();
    }
}
