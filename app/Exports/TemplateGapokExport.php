<?php

namespace App\Exports;

use App\Models\HRD\KaryawanModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TemplateGapokExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function view(): View
    {
        $data = [
            'list_karyawan' => KaryawanModel::select([
                "hrd_karyawan.id",
                "hrd_karyawan.nik",
                "hrd_karyawan.nm_lengkap",
                "hrd_karyawan.gaji_pokok",
                "hrd_karyawan.gaji_bpjs",
                "hrd_karyawan.gaji_jamsostek",
                "mst_hrd_jabatan.nm_jabatan",
                "mst_hrd_level_jabatan.level",
                "mst_hrd_departemen.nm_dept"
            ])
                ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
                ->leftJoin('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
                ->leftJoin('mst_hrd_level_jabatan', 'mst_hrd_jabatan.id_level', '=', 'mst_hrd_level_jabatan.id')
                ->where('hrd_karyawan.nik', '<>', '999999999')
                ->whereNotIn('hrd_karyawan.id_status_karyawan', [4, 5, 6])
                ->orderBy('mst_hrd_level_jabatan.level')->get()
        ];
        return view('HRD.setup.manajemen_gaji.template_gapok', $data);
    }
}
