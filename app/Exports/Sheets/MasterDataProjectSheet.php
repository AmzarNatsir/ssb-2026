<?php

namespace App\Exports\Sheets;

use App\Models\Tender\Project;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterDataProjectSheet implements FromQuery, WithHeadings, WithMapping, WithTitle
{

  public function query()
  {
    return Project::query();
  }

  public function map($project): array
  {
    return [
      $project->id,
      $project->name,
    ];
  }

  public function headings(): array
  {
    return [
      'project_id',
      'name',
    ];
  }

  public function title(): string
  {
    return 'Master Data Project';
  }
}
