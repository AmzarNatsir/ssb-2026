<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workshop\Equipment;

class WorkHour extends Model
{
    protected $table = "work_hours";
    protected $fillable = [
        'project_id',
        'operator_id',
        'equipment_id',
        'user_id',
        'km_start',
        'km_end',
        'hm_start',
        'hm_end',
        'shift',
        'operating_hour_start',
        'operating_hour_end',
        'break_hour_start',
        'break_hour_end',
        'break_hour_total',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function operator(){
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'operator_id', 'id');
    }

    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
