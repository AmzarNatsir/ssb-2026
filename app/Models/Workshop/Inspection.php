<?php

namespace App\Models\Workshop;

use App\Models\HRD\KaryawanModel;
use App\Repository\Workshop\Traits\WorkshopTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use SoftDeletes, WorkshopTrait;

    const PAGE_LIMIT = 50;
    const NUMBER_PREFIX = "IP.{year}.{month}";

    protected $table = 'wh_inspection';
    protected $fillable = [
        'date',
        'number',
        'equipment_id',
        'location_id',
        'project_id',
        'driver_id',
        'shift',
        'km_start',
        'km_end',
        'hm_start',
        'hm_end',
        'operating_hour',
        'standby_hour',
        'breakdown_hour',
        'standby_description',
        'breakdown_description',
        'created_by',
        'updated_by'
    ];

    public function save(array $options = [])
    {
        $loggedInUser = auth()->user()->id;

        if (!$this->created_by) {
            $this->created_by = $loggedInUser;
        }

        $this->updated_by = $loggedInUser;

        return parent::save($options);
    }

    public function generateNumber()
    {
        $this->number =  1;
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'driver_id', 'id');
    }

    public function scopeFilter($query, $options)
    {
        $options = collect($options);

        if ($options->has('equipment_id') && $options['equipment_id']) {
            $query->where('equipment_id', $options['equipment_id']);
        }

        if ($options->get('start') && $options->get('end')) {
            $start = date('Y-m-d', strtotime($options['start']));
            $end = date('Y-m-d', strtotime($options['end']));
            $query->whereDate('date', '>=', $start)
                ->whereDate('date', '<=', $end);
        }

        return $query;
    }

    public function updateEquipmentKmHm()
    {
        $this->equipment->update(['km' => $this->km_end, 'hm' => $this->hm_end]);
    }
}
