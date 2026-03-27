<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = "inspection";
    protected $fillable = [
        'inspection_checkpoint_id',
        'location_id',
        'equipment_id',
        'report_set_id',
        'officer_id',
        'checkpoint',
        'assignment_no'
    ];

    public function checkpoints()
    {
        return $this->hasMany(InspectionCheckpoint::class, 'inspection_id');
    }

    public function location()
    {
        return $this->hasOne(\App\Models\Workshop\Location::class, 'id','location_id');
    }

    public function equipment()
    {
        return $this->hasOne(\App\Models\Workshop\Equipment::class, 'id','equipment_id');
    }

    public function officer()
    {
        return $this->hasOne(\App\Models\HRD\KaryawanModel::class, 'id', 'officer_id');
    }
}
