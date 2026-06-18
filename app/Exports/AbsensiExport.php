<?php

namespace App\Exports;

use App\Models\HRD\AbsensiModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class AbsensiExport implements FromView
{
    use Exportable;

    protected $bulan;
    protected $tahun;
    protected $departemen;

    public function __construct($bulan, $tahun, $departemen)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->departemen = $departemen;
    }

    public function view(): View
    {
        $data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($this->bulan);
        $data['ket_tahun'] = $this->tahun;
        $data['ket_departemen'] = ($this->departemen == 0)
            ? 'Semua Departemen'
            : optional(\App\Models\HRD\DepartemenModel::find($this->departemen))->nm_dept;
        $data['list_data'] = AbsensiModel::rekap_bulanan($this->bulan, $this->tahun, $this->departemen);

        return view('HRD.pelaporan.absensi.result_export', $data);
    }
}
