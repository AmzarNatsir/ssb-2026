<?php

namespace App\Exports\Sheets;

use App\Models\HRD\KaryawanModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterDataDriverSheet implements FromQuery, WithHeadings, WithMapping, WithTitle
{

  public function query()
  {
    return KaryawanModel::where('id_jabatan', workshop_settings('driver_position'));
  }

  public function map($driver): array
  {
    return [
      $driver->id,
      $driver->nm_lengkap,
    ];
  }

  public function headings(): array
  {
    return [
      'driver_id',
      'name',
    ];
  }

  public function title(): string
  {
    return 'Master Data Driver';
  }
}
