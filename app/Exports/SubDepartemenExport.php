<?php

namespace App\Exports;

use App\Models\HRD\SubDepartemenModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubDepartemenExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SubDepartemenModel::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'id departemen',
            'nama sub departemen',
            'created_at',
            'updated_at',
            'id divisi'
        ];
    }
}
