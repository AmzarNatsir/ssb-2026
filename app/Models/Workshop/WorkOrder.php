<?php

namespace App\Models\Workshop;

use App\Models\Workshop\UnitInspection;
use App\Models\HRD\KaryawanModel;
use App\Models\Tender\Project;
use App\Models\Workshop\MasterData\AdditionalAttributes;
use App\Models\Workshop\MasterData\Media;
use App\Repository\Workshop\Traits\WorkshopTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
  use SoftDeletes, WorkshopTrait;

  const PAGE_LIMIT = 50;
  const NUMBER_PREFIX = 'WO.{year}.{month}.';

  const REPAIRING_PLAN = [
    1 => 'PENYETELAN',
    2 => 'PELUMASAN',
    3 => 'SERVICE BERKALA',
    4 => 'PEMBERSIHAN',
    5 => 'PABRIKASI',
    6 => 'OVER HOUL',
    7 => 'PENGGANTIAN',
    8 => 'PEMERIKSAAN/INSPEKSI',
    9 => 'MOFDIFIKASI'
  ];

  const CAN_BE_REOPERATED = [
    1 => 'DENGAN CATATAN',
    2 => 'TANPA CATATAN'
  ];
  const NEED_FURTHER_TREATMENT = [
    1 => 'SITE',
    2 => 'WORKSHOP'
  ];
  const STATUS_OPEN = 0;
  const STATUS_CLOSED = 1;

  protected $table = 'work_order';
  protected $fillable = [
    'number',
    'work_request_id',
    'equipment_id',
    'driver_id',
    'project_id',
    'supervisor_id',
    'hm',
    'km',
    'date_start',
    'date_finish',
    'man_powers',
    'repairing_plan',
    'damage_source_analysis',
    'can_be_reoperated',
    'need_further_treatment',
    'remarks',
    'crated_by',
    'updated_by',
    'status',
    'location_id'
  ];

  public function save(array $options = [])
  {
    $loggedInUser = auth()->user()->id;

    if (!$this->created_by) {
      $this->created_by = $loggedInUser;
    }

    if (!$this->number) {
      $this->number = $this->generateNumber();
    }

    $this->updated_by = $loggedInUser;

    return parent::save($options);
  }

  public function equipment()
  {
    return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
  }

  public function work_request()
  {
    return $this->belongsTo(WorkRequest::class, 'work_request_id', 'id');
  }

  public function unitInspection(): HasOne
  {
    return $this->hasOne(UnitInspection::class)->withDefault();
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
      $query->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=', $end);
    }
    return $query;
  }

  public function setManPowersAttribute($value)
  {
    $this->attributes['man_powers'] = serialize($value);
  }

  public function setRepairingPlanAttribute($value)
  {
    $this->attributes['repairing_plan'] = serialize($value);
  }

  public function getRepairingPlanAttribute($value)
  {
    return unserialize($value);
  }

  public function getManPowersAttribute($value)
  {
    $value = unserialize($value);
    if ($value) {
      $karyawan = KaryawanModel::whereIn('id', $value)->get()->transform(function ($item) {
        return collect(['id' => $item->id, 'name' => $item->nm_lengkap]);
      })->values();

      return $karyawan;
    }

    return '';
  }

  public function additional_attributes()
  {
    return $this->morphMany(AdditionalAttributes::class, 'additional_attributeable', 'reference_type', 'reference_id');
  }

  public function media()
  {
    return $this->morphMany(Media::class, 'workshop_mediable', 'model', 'model_id');
  }

  public function updateEquipmentStatusToUnderMainteanance()
  {
    $this->equipment->status = array_search('Under Mainteanance', \App\Models\Workshop\Equipment::STATUS);
  }

  public function tools()
  {
    return $this->morphOne(ToolUsage::class, 'toolable', 'reference', 'reference_id');
  }

  public function scopeActive($query)
  {
    return $query->where('status', static::STATUS_OPEN);
  }

  public function scopeNotInTools($query)
  {
    return $query->whereNotIn('id', function ($q) {
      return $q->select('reference_id')->from('tool_usage')->where('reference', self::class)->where('deleted_at', NULL);
    });
  }

  public function complete()
  {
    $this->status = static::STATUS_CLOSED;
    $this->work_request->update(['status' => 4]);
    return $this->save();
  }

  public function toolHistory()
  {
    return $this->morphMany(ToolHistory::class, 'toolHistory', 'type', 'type_id');
  }

  public function setEquipmentStatusToUnderMainteanance()
  {
    return $this->equipment->update(['status' => array_search('Under Mainteanance', Equipment::STATUS)]);
  }

  public function setWorkRequestStatusToWO()
  {
    return $this->work_request->update(['status' =>  3]);
  }

  public function supervisor()
  {
    return $this->belongsTo(KaryawanModel::class, 'supervisor_id', 'id');
  }
}
