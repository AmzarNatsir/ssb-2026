<?php

namespace App\Repository\Workshop;

use App\Models\Workshop\InspectionChecklistGroup;
use App\Models\Workshop\InspectionChecklistItem;

class InspectionChecklistsUpsertAction
{
  public $errors = [];

  function __construct(public $params){}

  public function upsert(){
    try {
      $savedGroupIds = [];
      $savedItemIds  = [];

      foreach ($this->params as $groupKey => $groupValue) {
        $checklist_group = InspectionChecklistGroup::firstOrNew(['name' => strtoupper($groupValue["value"]) ]);
        $checklist_group->order = $groupKey;
        $checklist_group->save();

        array_push($savedGroupIds, $checklist_group->id);

        foreach ($groupValue['items'] as $itemKey => $itemValue) {
          $checklist_item = $checklist_group->inspectionChecklistItems()
                                            ->firstOrNew(['name' => strtoupper($itemValue)]);
          $checklist_item->order = $itemKey;
          $checklist_item->save();

          array_push($savedItemIds, $checklist_item->id);
        }
      }

      InspectionChecklistGroup::whereNotIn('id', $savedGroupIds)->delete();
      InspectionChecklistItem::whereNotIn('id', $savedItemIds)->delete();

      return true;
    } catch (\Throwable $th) {
      array_push($this->errors, $th->getMessage());
      return false;
    }
  }
}
