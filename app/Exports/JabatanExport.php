<?php

namespace App\Exports;

use App\Models\HRD\JabatanModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JabatanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JabatanModel::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'id level',
            'id departemen',
            'id sub departemen',
            'id gakom',
            'id gakor',
            'nama jabatan',
            'status',
            'created_at',
            'updated_at',
            'id divisi'
        ];
    }
}
