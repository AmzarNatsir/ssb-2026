<?php
namespace App\Repository\Workshop;

use App\Models\Workshop\UnitInspection;

class UnitInspectionsInitAction{
  public $errors = [];
  public $unitInspection;

  function __construct(public $workOrder){
    try {
      $unitInspection = $this->workOrder->unitInspection;
      $equipment      = $this->workOrder->equipment;

      if (is_null($unitInspection->id)) {
        $unitInspection->hm         = $equipment->hm;
        $unitInspection->km         = $equipment->km;
        $unitInspection->status     = UnitInspection::STATUS['ONPROGRESS'];
        $unitInspection->checklists = $unitInspection->buildChecklists();
        $unitInspection->save();
      }

      $this->unitInspection = $unitInspection->fresh();
      return $this;
    } catch (\Throwable $th) {
      array_push($this->errors, $th->getMessage());
      return false;
    }
  }
}
