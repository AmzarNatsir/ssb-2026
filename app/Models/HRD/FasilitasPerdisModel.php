<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class FasilitasPerdisModel extends Model
{
    protected $table = "mst_hrd_fasilitas_perdis";
    protected $fillable = ["nm_fasilitas", "status"];
}
