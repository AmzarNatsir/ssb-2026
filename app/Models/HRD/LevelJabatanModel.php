<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class LevelJabatanModel extends Model
{
    protected $table = "mst_hrd_level_jabatan";
    protected $fillable = ["nm_level", "level", "sts_dept", "sts_subdept", "sts_gakom", "sts_gakor", "status"];
    
}
