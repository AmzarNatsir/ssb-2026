<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTanggunganModel extends Model
{
    use HasFactory;
    protected $table = "mst_hrd_status_tanggungan";
    protected $fillable = [
        "status_tanggungan",
        "kode",
        "status"
    ];

}
