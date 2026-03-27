<?php

namespace App\Exports;

use App\Models\HRD\PerdisModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PerdisExport implements FromView
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
        $data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($this->bulan);
        $data['ket_tahun'] = $this->tahun;
        if($this->departemen==0) {
            $data['list_data'] = PerdisModel::where('sts_pengajuan', 2)->wheremonth('tgl_perdis', $this->bulan)->whereyear('tgl_perdis', $this->tahun)->orderby('tgl_perdis')->get();
        } else {
            $data['list_data'] = PerdisModel::where('sts_pengajuan', 2)->where('id_departemen', $this->departemen)->wheremonth('tgl_perdis', $this->bulan)->whereyear('tgl_perdis', $this->tahun)->orderby('tgl_perdis')->get();
        }
        return view('HRD.pelaporan.perdis.result_export', $data);
    }
}
