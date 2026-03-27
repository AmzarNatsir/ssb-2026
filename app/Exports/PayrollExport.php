<?php

namespace App\Exports;

use App\Models\HRD\DepartemenModel;
use App\Models\HRD\PayrollModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;


class PayrollExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $bulan;
    protected $tahun;
    protected $departemen;

    public function __construct(string $id_tahun, $id_bulan, $departemen)
    {
        $this->bulan = $id_tahun;
        $this->tahun = $id_bulan;
        $this->departemen = $departemen;
    }

    public function view(): View
    {
        $data['ket_periode'] = \App\Helpers\Hrdhelper::get_nama_bulan($this->bulan). " ".$this->tahun;
        if($this->departemen==0)
        {
            $data['departemen'] = "All Departemen";
            $data['list_data'] = PayrollModel::where('bulan', $this->bulan)->where('tahun', $this->tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        } else {
            $data['departemen'] = DepartemenModel::find($this->departemen)->nm_dept;
            $data['list_data'] = PayrollModel::where('id_departemen', $this->departemen)->where('bulan', $this->bulan)->where('tahun', $this->tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        }
        return view('HRD.pelaporan.penggajian.result_export', $data);
    }
}
