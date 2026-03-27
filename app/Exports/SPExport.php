<?php

namespace App\Exports;

use App\Models\HRD\SuratPeringatanModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class SPExport implements FromView
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
        if($this->bulan=="0" && $this->departemen=="0") {
            $result = SuratPeringatanModel::where('sts_pengajuan', 2)->whereyear('tgl_sp', $this->tahun)->orderby('tgl_sp')->get();
            $ket_bulan = "0";
        } else if($this->departemen==0) {
            $result = SuratPeringatanModel::where('sts_pengajuan', 2)->wheremonth('tgl_sp', $this->bulan)->whereyear('tgl_sp', $this->tahun)->orderby('tgl_sp')->get();
            $ket_bulan = \App\Helpers\Hrdhelper::get_nama_bulan($this->bulan);
        } else {
            $result = SuratPeringatanModel::where('sts_pengajuan', 2)->where('id_departemen', $this->departemen)->wheremonth('tgl_sp', $this->bulan)->whereyear('tgl_sp', $this->tahun)->orderby('tgl_sp')->get();
            $ket_bulan = \App\Helpers\Hrdhelper::get_nama_bulan($this->bulan);
        }

        $data['ket_bulan'] = $ket_bulan;
        $data['ket_tahun'] = $this->tahun;
        $data['list_data'] = $result;
        return view('HRD.pelaporan.sp.result_export', $data);
    }
}
