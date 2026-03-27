<?php

namespace App\Exports;

use App\Models\HRD\KaryawanModel;
use App\Models\HRD\SetupBPJSModel;
use App\Traits\Payroll;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PenggajianTemplate implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Payroll;
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
        $res_persen_bpjs = SetupBPJSModel::first();
        //potongan
        $persen_bpjsks_karyawan = (empty($res_persen_bpjs->bpjsks_karyawan)) ? '0' : $res_persen_bpjs->bpjsks_karyawan;
        $persen_jkm_karyawan = (empty($res_persen_bpjs->jkm_karyawan)) ? '0' : $res_persen_bpjs->jkm_karyawan;
        $persen_jkk_karyawan = (empty($res_persen_bpjs->jkk_karyawan)) ? '0' : $res_persen_bpjs->jkk_karyawan;
        $persen_jht_karyawan = (empty($res_persen_bpjs->jht_karyawan)) ? '0' : $res_persen_bpjs->jht_karyawan;
        $persen_jp_karyawan = (empty($res_persen_bpjs->jp_karyawan)) ? '0' : $res_persen_bpjs->jp_karyawan;
        //tunjangan perusahaan
        $persen_bpjsks_perus = (empty($res_persen_bpjs->bpjsks_perusahaan)) ? '0' : $res_persen_bpjs->bpjsks_perusahaan;
        $persen_jht_perus = (empty($res_persen_bpjs->jht_perusahaan)) ? '0' : $res_persen_bpjs->jht_perusahaan;
        $persen_jkk_perus = (empty($res_persen_bpjs->jkk_perusahaan)) ? '0' : $res_persen_bpjs->jkk_perusahaan;
        $persen_jkm_perus = (empty($res_persen_bpjs->jkm_perusahaan)) ? '0' : $res_persen_bpjs->jkm_perusahaan;
        $persen_jp_perus = (empty($res_persen_bpjs->jp_perusahaan)) ? '0' : $res_persen_bpjs->jp_perusahaan;
        $resKaryawan = KaryawanModel::select([
            "hrd_karyawan.id",
            "hrd_karyawan.nik",
            "hrd_karyawan.nm_lengkap",
            "hrd_karyawan.id_status_karyawan",
            "mst_hrd_jabatan.nm_jabatan",
            "mst_hrd_level_jabatan.level",
            "mst_hrd_departemen.nm_dept",
            "hrd_karyawan.gaji_pokok",
            "hrd_karyawan.gaji_bpjs",
            "hrd_karyawan.gaji_jamsostek",
            "hrd_karyawan.id_departemen",
            "hrd_karyawan.bpjs_kesehatan",
            "hrd_karyawan.bpjs_tk_jht",
            "hrd_karyawan.bpjs_tk_jkk",
            "hrd_karyawan.bpjs_tk_jkm",
            "hrd_karyawan.bpjs_tk_jp",
            "hrd_karyawan.id_status_karyawan",
            "hrd_karyawan.tgl_masuk",
        ])
            ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
            ->leftJoin('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
            ->leftJoin('mst_hrd_level_jabatan', 'mst_hrd_jabatan.id_level', '=', 'mst_hrd_level_jabatan.id')
            ->where('hrd_karyawan.nik', '<>', '999999999')
            ->whereIn('hrd_karyawan.id_status_karyawan', [1, 2, 3, 7])
            ->orderBy('mst_hrd_level_jabatan.level')->get()->map( function($row) use (
                $persen_bpjsks_karyawan,
                $persen_bpjsks_perus,
                $persen_jkm_karyawan,
                $persen_jkm_perus,
                $persen_jkk_karyawan,
                $persen_jkk_perus,
                $persen_jht_perus,
                $persen_jht_karyawan,
                $persen_jp_perus,
                $persen_jp_karyawan
                ) {
                $arr = $row->toArray();
                $arr['pot_bpjsks_karyawan'] = (empty($arr['bpjs_kesehatan'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_bpjsks_karyawan);
                $arr['tunj_bpjsks_perusahaan'] = (empty($arr['bpjs_kesehatan'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_bpjsks_perus);
                $arr['pot_jkm_karyawann'] = (empty($arr['bpjs_tk_jkm'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jkm_karyawan);
                $arr['tunj_jkm_perusahaan'] = (empty($arr['bpjs_tk_jkm'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jkm_perus);
                $arr['pot_jkk_karyawann'] = (empty($arr['bpjs_tk_jkk'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jkk_karyawan);
                $arr['tunj_jkk_perusahaan'] = (empty($arr['bpjs_tk_jkk'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jkk_perus);
                $arr['pot_jht_karyawann'] = (empty($arr['bpjs_tk_jht'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jht_karyawan);
                $arr['tunj_jht_perusahaan'] = (empty($arr['bpjs_tk_jht'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jht_perus);
                $arr['pot_jp_karyawann'] = (empty($arr['bpjs_tk_jp'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jp_karyawan);
                $arr['tunj_jp_perusahaan'] = (empty($arr['bpjs_tk_jp'])) ? 0 : Payroll::getPotTunjBpjs($arr['gaji_bpjs'], $persen_jp_perus);
                return $arr;
            });

            // dd($resKaryawan);
        $data = [
            'list_karyawan' => $resKaryawan,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'list_status' => Config::get("constants.status_karyawan")
        ];

        return view('HRD.penggajian.tools.template_penggajian', $data);
    }
}
