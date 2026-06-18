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
    protected $id_jabatan;

    public function __construct($id_dept, $bulan, $tahun, $id_jabatan = null)
    {
        $this->id_dept = $id_dept;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->id_jabatan = $id_jabatan;
    }

    public function view(): View
    {
        $data['grid'] = AbsensiModel::grid_bulanan($this->id_dept, $this->bulan, $this->tahun, $this->id_jabatan);
        $data['ket_departemen'] = optional(DepartemenModel::find($this->id_dept))->nm_dept;

        return view('HRD.absensi.result_export', $data);
    }
}
