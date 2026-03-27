<?php

namespace App\Exports;

use App\Models\HRD\DivisiModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DivisiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DivisiModel::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'nama divisi',
            'created_at',
            'updated_at',
            'status'
        ];
    }
}
