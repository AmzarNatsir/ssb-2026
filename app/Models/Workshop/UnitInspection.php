<?php

namespace App\Models\Workshop;

use App\Models\HRD\KaryawanModel;
use App\Models\Workshop\Location;
use App\Models\Workshop\WorkOrder;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

class UnitInspection extends Model
{
  protected $fillable = [
    'hm',
    'km',
    'location_id',
    'mechanic_id',
    'user_id',
    'status',
    'check_result',
    'checklists',
    'inspection_date',
    'remarks'
  ];

  const STATUS = [
    'ONPROGRESS' => 0,
    'COMPLETED' => 1
  ];

  public function workOrder(): BelongsTo
  {
    return $this->belongsTo(WorkOrder::class);
  }

  public function location() : BelongsTo {
    return $this->belongsTo(Location::class);
  }

  public function user() : HasOne {
    return $this->hasOne(User::class);
  }

  public function mechanic() : HasOne {
    return $this->hasOne(KaryawanModel::class, 'id', 'mechanic_id');
  }

  public function save(array $options = []){
    $loggedInUser = auth()->user()->id;

    if (!$this->user_id) {
      $this->user_id = $loggedInUser;
    }

    return parent::save($options);
  }

  public function buildChecklists() {
    return InspectionChecklistGroup::all()->sortBy("order")->map(function($value, $key){
      return [
        "checklist_group_name" => $value->name,
        "order" => $value->order,
        "checklist_items" => $value->inspectionChecklistItems->sortBy("order")->map(function($item, $itemKey){
          return [
            "checklist_item_name" => $item->name,
            "check_result" => null,
            "remarks" => "",
            "order" => $item->order
          ];
        })
      ];
    });
  }

  public function getChecklistsArrayAttribute() :array
  {
    if (isset($this->checklists)){
      return json_decode($this->checklists, true);
    }

    return [];
  }
}
