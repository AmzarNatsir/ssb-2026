<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class RefApprovalModel extends Model
{
    protected $table = "ref_approval";
    protected $fillable = [
        "id" , "ref_group"
    ];

}
