<?php

namespace App\Exports;

use App\Models\HRD\KaryawanModel;
use App\Models\HRD\DepartemenModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class KaryawanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $id;

    public function __construct(string $id_departemen)
    {
        $this->id = $id_departemen;
    }
    /*
    public function collection()
    {
        //return KaryawanModel::all();

        return KaryawanModel::wherein('id_status_karyawan', [1, 2, 3])->where('id_departemen', $this->id)->orderby('nik')->get();
    }
    */
    public function view(): View
    {
        if($this->id==0)
        {
            $ket_departemen = "Semua Departemen";
            $list_karyawan = KaryawanModel::wherein('id_status_karyawan', [1, 2, 3, 7])
            ->orderBy('id_jabatan')
            ->orderBy('nik')
            ->orderBy('tgl_masuk')->get();
        } else {
            $ket_departemen = DepartemenModel::find($this->id)->nm_dept;
            $list_karyawan = KaryawanModel::wherein('id_status_karyawan', [1, 2, 3, 7])
            ->where('id_departemen', $this->id)
            ->orderBy('id_jabatan')
            ->orderBy('nik')
            ->orderBy('tgl_masuk')->get();
        }
        return view('HRD.pelaporan.karyawan.result_export', ['ket_departemen' => $ket_departemen, 'list_karyawan'=>$list_karyawan]);
    }
}
