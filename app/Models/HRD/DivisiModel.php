<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class DivisiModel extends Model
{
    protected $table = "mst_hrd_divisi";
    protected $fillable = ['nm_divisi'];
}
