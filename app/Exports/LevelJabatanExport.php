<?php

namespace App\Exports;

use App\Models\HRD\LevelJabatanModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LevelJabatanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LevelJabatanModel::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'nama level',
            'status_dept',
            'sts_subdept',
            'sts_gakom',
            'sts_gakor',
            'status',
            'create_at',
            'updated_at',
            'level'
        ];
    }
}
