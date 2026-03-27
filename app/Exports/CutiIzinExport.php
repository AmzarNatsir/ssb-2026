<?php

namespace App\Exports;

use App\Models\HRD\CutiModel;
use App\Models\HRD\IzinModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class CutiIzinExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $bulan;
    protected $tahun;
    protected $departemen;

    public function __construct(string $id_tahun, $id_bulan, $id_kategori, $departemen)
    {
        $this->bulan = $id_tahun;
        $this->tahun = $id_bulan;
        $this->kategori = $id_kategori;
        $this->departemen = $departemen;
    }

    public function view(): View
    {
        $data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($this->bulan);
        $data['ket_tahun'] = $this->tahun;
        $data['ket_kategori'] = ($this->kategori==1) ? "CUTI" : "IZIN";
        if($this->kategori==1) //Cuti
        {
            if($this->departemen==0){
                $data['list_data'] = CutiModel::wheremonth('tgl_awal', $this->bulan)->whereyear('tgl_awal', $this->tahun)->where('sts_pengajuan', 2)->orderby('tgl_awal')->get();
            } else {
                $data['list_data'] = CutiModel::where('id_departemen', $this->departemen)->wheremonth('tgl_awal', $this->bulan)->whereyear('tgl_awal', $this->tahun)->where('sts_pengajuan', 2)->orderby('tgl_awal')->get();
            }

            return view('HRD.pelaporan.cuti_izin.result_export_cuti', $data);
        } else {
            if($this->departemen==0){
                $data['list_data'] = IzinModel::where('sts_pengajuan', 2)->wheremonth('tgl_awal', $this->bulan)->whereyear('tgl_awal', $this->tahun)->orderby('tgl_awal')->get();
            } else {
                $data['list_data'] = IzinModel::where('sts_pengajuan', 2)->where('id_departemen', $this->departemen)->wheremonth('tgl_awal', $this->bulan)->whereyear('tgl_awal', $this->tahun)->orderby('tgl_awal')->get();
            }

            return view('HRD.pelaporan.cuti_izin.result_export_izin', $data);
        }
        return CutiModel::all();
    }
}
