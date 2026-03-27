<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PayrollHeaderModel extends Model
{
    protected $table = "hrd_payroll_header";
    protected $fillable = [
        'bulan',
        'tahun',
        'approval_key',
        'status_pengajuan',
        'current_approval_id',
        'is_draft',
        'diajukan_oleh'
    ];

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }

    public function get_diajukan_oleh(){
        return $this->belongsTo('app\User', 'diajukan_oleh', 'id');
    }
}
