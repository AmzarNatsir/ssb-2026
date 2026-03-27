<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class BankPenggajianModel extends Model
{
    protected $table = "mst_hrd_bank";
    protected $fillable = ['nm_bank', 'status'];
}
