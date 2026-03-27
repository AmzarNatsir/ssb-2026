<?php

namespace App\Exports;

use App\Models\HRD\AbsensiModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class AbsensiTemplateExport implements FromView, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    public function view(): View
    {
        return view('HRD.karyawan.tools.template_absensi');
    }

    public function title(): string
    {
        return 'Daftar Kehadiran Karyawan'; // This will be the sheet name
    }
}
