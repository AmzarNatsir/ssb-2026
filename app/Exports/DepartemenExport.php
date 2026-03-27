<?php

namespace App\Exports;

use App\Models\HRD\DepartemenModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartemenExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DepartemenModel::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'nama departemen',
            'status',
            'created_at',
            'updated_at',
            'id divisi'
        ];
    }
}
