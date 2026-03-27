<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class InspectionImportSheet implements WithHeadings, WithTitle
{

  public function headings(): array
  {
    return [
      'Date',
      'Unit Id',
      'Project Id',
      'Operator Id',
      'Shift',
      'KM Start',
      'KM End',
      'HM Start',
      'HM End',
      'Operating Hour',
      'Standby Hour',
      'Standby Description',
      'Breakdown Hour',
      'Breakdown Description'
    ];
  }

  public function title(): string
  {
    return 'Data Inspection';
  }
}
