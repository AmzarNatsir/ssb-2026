<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class JenisSPModel extends Model
{
    protected $table = "mst_hrd_jenis_sp";
    protected $fillable = ['nm_jenis_sp', 'status', 'lama_berlaku'];
}
