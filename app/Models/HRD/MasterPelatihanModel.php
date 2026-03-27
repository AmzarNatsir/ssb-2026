<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class MasterPelatihanModel extends Model
{
    protected $table = "mst_hrd_pelatihan";
    protected $fillable = ['nama_pelatihan'];
}
