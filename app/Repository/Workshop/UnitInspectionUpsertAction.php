<?php

namespace App\Repository\Workshop;

class UnitInspectionUpsertAction
{
  public $errors = [];

  function __construct(public $unitInspection, private $params)
  {
  }

  public function upsert(){
    try {
      $this->unitInspection->hm = $this->params["hm"];
      $this->unitInspection->km = $this->params["km"];
      $this->unitInspection->location_id = $this->params["location_id"];
      $this->unitInspection->mechanic_id = $this->params["mechanic_id"];
      $this->unitInspection->check_result = $this->params["check_result"];
      $this->unitInspection->inspection_date = $this->params["inspection_date"];
      $this->unitInspection->remarks = $this->params["remarks"];
      $this->unitInspection->checklists = $this->normalizeChecklists();
      $this->unitInspection->save();
      $this->unitInspection->fresh();

      return true;
    } catch (\Throwable $th){
      array_push($this->errors, $th->getMessage());
      return false;
    }

  }

  private function normalizeChecklists(){
    try {
      return collect($this->params["checklist_group_name"])->map(function($groupValue, $groupKey){
        return [
          "checklist_group_name" => $groupValue,
          "order" => $groupKey,
          "checklist_items" => collect($this->params["checklist_items"][$groupKey])->map(function ($itemValue, $itemKey) use($groupKey){
            return [
              "checklist_item_name" => $itemValue,
              "check_result" => $this->params["checklist_item_results"][$groupKey][$itemKey],
              "remarks" => $this->params["checklist_item_remarks"][$groupKey][$itemKey],
              "order" => $itemKey
            ];
          })
        ];
      });
    } catch (\Throwable $th){
      array_push($this->errors, $th->getMessage());
      throw new \Exception($th->getMessage());
    }
  }
}
