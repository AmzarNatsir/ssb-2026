<?php

namespace App\Exports;

use App\Exports\Sheets\InspectionImportSheet;
use App\Exports\Sheets\MasterDataDriverSheet;
use App\Exports\Sheets\MasterDataEquipmentSheet;
use App\Exports\Sheets\MasterDataProjectSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InspectionImportTemplate implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[0] = new InspectionImportSheet();
        $sheets[1] = new MasterDataEquipmentSheet();
        $sheets[2] = new MasterDataProjectSheet();
        $sheets[3] = new MasterDataDriverSheet();

        return $sheets;
    }
}
