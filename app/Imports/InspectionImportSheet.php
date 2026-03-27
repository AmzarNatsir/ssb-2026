<?php
namespace App\Imports;

use App\Models\Tender\Project;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\Inspection;
use Maatwebsite\Excel\Concerns\ToModel;

class InspectionImportSheet implements ToModel
{
  public function model(array $row)
  {
    if ($row[0] == 'Date') {
      return null;
    }

    $date      = \Carbon\Carbon::create($row[0])->toDateString();
    $equipment = $row[1];
    $project   = $row[2];
    $driver    = $row[3];
    $shift     = $row[4];
    $km_start  = $row[5];
    $km_end    = $row[6];
    $hm_start  = $row[7];
    $hm_end    = $row[8];
    $oh        = $row[9];
    $sh        = $row[10];
    $sd        = $row[11];
    $bh        = $row[12];
    $bd        = $row[13];

    $inspection = Inspection::firstOrNew(
      ['date' => $date, 'equipment_id' => $equipment, 'project_id' => $project, 'driver_id' => $driver]
    );

    $equipment_obj = Equipment::find($equipment);

    $inspection->number                = 'system';
    $inspection->location_id           = $equipment_obj->location_id;
    $inspection->shift                 = $shift;
    $inspection->km_start              = $km_start;
    $inspection->km_end                = $km_end;
    $inspection->hm_start              = $hm_start;
    $inspection->hm_end                = $hm_end;
    $inspection->shift                 = $shift;
    $inspection->operating_hour        = $oh;
    $inspection->standby_hour          = $sh;
    $inspection->breakdown_hour        = $bh;
    $inspection->standby_description   = $sd;
    $inspection->breakdown_description = $bd;
    $inspection->save();
  }
}
