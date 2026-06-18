<?php

namespace App\Exports;

use App\Models\HRD\AbsensiModel;
use App\Models\HRD\DepartemenModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class AbsensiMonitoringExport implements FromView
{
    use Exportable;

    protected $id_dept;
    protected $bulan;
    protected $tahun;

    public function __construct($id_dept, $bulan, $tahun)
    {
        $this->id_dept = $id_dept;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $data['grid'] = AbsensiModel::grid_bulanan($this->id_dept, $this->bulan, $this->tahun);
        $data['ket_departemen'] = optional(DepartemenModel::find($this->id_dept))->nm_dept;

        return view('HRD.absensi.result_export', $data);
    }
}
