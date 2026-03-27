<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefApprovalDetailModel extends Model
{
    use HasFactory;
    protected $table = "ref_approval_detail";
    protected $fillable = [
        "approval_group",
        "approval_level",
        "approval_by_employee",
        "approval_departemen"
    ];

    public function getPejabat()
    {
        return $this->belongsTo(KaryawanModel::class, 'approval_by_employee', 'id');
    }
}
