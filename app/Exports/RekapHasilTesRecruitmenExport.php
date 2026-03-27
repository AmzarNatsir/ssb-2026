<?php

namespace App\Exports;

use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\PelamarModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RekapHasilTesRecruitmenExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $jabatan;
    protected $departemen;

    public function __construct(string  $departemen, $jabatan)
    {
        $this->departemen = $departemen;
        $this->jabatan = $jabatan;
    }

    public function view(): View
    {
        $query = PelamarModel::with([
            'get_departmen',
            'get_jabatan'
        ])->where('status_pengajuan', 1);
        if(!empty($this->departemen))
        {
            $query->where('id_departemen', $this->departemen);
        }
        if(!empty($this->jabatan))
        {
            $query->where('id_jabatan',$this->jabatan);
        }
        $list = $query->orderBy('total_skor', 'desc')
            ->get();

        $data = [
            'departemen' => DepartemenModel::find($this->departemen),
            'jabatan' => JabatanModel::find($this->jabatan),
            'list' => $list,
        ];
        return view('HRD.recruitment.hasil_tes.result_export', $data);
    }
}
