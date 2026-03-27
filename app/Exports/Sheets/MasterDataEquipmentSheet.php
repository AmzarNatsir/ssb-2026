<?php

namespace App\Exports\Sheets;

use App\Models\Workshop\Equipment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterDataEquipmentSheet implements FromQuery, WithHeadings, WithMapping, WithTitle
{

  public function query()
  {
    return Equipment::query();
  }

  public function map($equipment): array
  {
    return [
      $equipment->id,
      $equipment->code,
      $equipment->name,
      $equipment->model
    ];
  }

  public function headings(): array
  {
    return [
      'equipment_id',
      'code',
      'name',
      'model'
    ];
  }

  public function title(): string
  {
    return 'Master Data Equipment';
  }
}
