<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;

class ProjectMutasi extends Model
{
    protected $table = "project_mutasi";
    protected $fillable = [
        'project_id',
        'employee_id',
        'new_dept',
        'new_jabt',
        'eff_date',
        'ketera',
        'created_by',
        'updated_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(DepartemenModel::class, 'new_dept');
    }

    public function jabatan()
    {
        return $this->belongsTo(JabatanModel::class, 'new_jabt');
    }

    public function createdBy()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }
}
