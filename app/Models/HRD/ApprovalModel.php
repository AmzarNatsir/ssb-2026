<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class ApprovalModel extends Model
{
    protected $table = "hrd_approval";
    protected $fillable = [
        "approval_key",
        "approval_group",
        "approval_level",
        "approval_by_employee",
        "approval_date",
        "approval_status",
        "approval_remark",
        "approval_active"
    ];

    public function get_profil_employee()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'approval_by_employee', 'id');
    }
    public function get_ref_approval()
    {
        return $this->belongsTo('App\Models\HRD\RefApprovalModel', 'approval_group', 'id');
    }
}
