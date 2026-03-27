<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class UangSakuPerdisModel extends Model
{
    protected $table = "mst_hrd_uangsaku_perdis";
    protected $fillable = ['nominal', 'status'];
}
