<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InspectionImport implements WithMultipleSheets
{
  public function sheets(): array
  {
    return [
      new InspectionImportSheet()
    ];
  }
}

