<?php

namespace App\Exports;

use App\Models\HRD\KaryawanModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class BonusTemplate implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $bulan;
    protected $tahun;

    public function __construct(string $tahun, $bulan)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $resKaryawan = KaryawanModel::select([
            "hrd_karyawan.id",
            "hrd_karyawan.nik",
            "hrd_karyawan.nm_lengkap",
            "hrd_karyawan.id_status_karyawan",
            "mst_hrd_jabatan.nm_jabatan",
            "mst_hrd_level_jabatan.level",
            "mst_hrd_departemen.nm_dept",
            "hrd_karyawan.gaji_pokok",
        ])
            ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
            ->leftJoin('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
            ->leftJoin('mst_hrd_level_jabatan', 'mst_hrd_jabatan.id_level', '=', 'mst_hrd_level_jabatan.id')
            ->where('hrd_karyawan.nik', '<>', '999999999')
            ->where('hrd_karyawan.id_status_karyawan', 7) //status harian
            ->orderBy('mst_hrd_level_jabatan.level')->get();

            // dd($resKaryawan);
        $data = [
            'list_karyawan' => $resKaryawan,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ];

        return view('HRD.penggajian.tools.template_bonus', $data);
    }
}
