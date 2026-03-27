<?php

namespace App\Imports;

use App\Models\HRD\PayrollModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeriodePenggajianImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $row)
    {
        foreach($row as $row) {
            if(!empty($row["id_karyawan"])) {
                $dataExisting = PayrollModel::where('id_karyawan', $row["id_karyawan"])
                        ->where('bulan', $row["bulan"])
                        ->where('tahun', $row["tahun"])->count();
                if($dataExisting==0) {
                    $data = [
                        "id_karyawan" => $row["id_karyawan"],
                        "id_departemen" => $row["id_departemen"],
                        "bulan" => $row["bulan"],
                        "tahun" => $row["tahun"],
                        "gaji_pokok" => (empty($row['gaji_pokok'])) ? 0 : $row['gaji_pokok'],
                        "gaji_bpjs" => (empty($row['gaji_bpjs'])) ? 0 : $row['gaji_bpjs'],
                        "tunj_perusahaan" => (empty($row['tunj_bpjs'])) ? 0 : $row['tunj_bpjs'],
                        "tunj_tetap" => (empty($row['tunj_tetap'])) ? 0 : $row['tunj_tetap'],
                        "hours_meter" => (empty($row['hours_meter'])) ? 0 : $row['hours_meter'],
                        "lembur" => (empty($row['lembur'])) ? 0 : $row['lembur'],
                        "bonus" => (empty($row['bonus'])) ? 0 : $row['bonus'],
                        "bpjsks_perusahaan" => (empty($row['bpjsks_perusahaan'])) ? 0 : $row['bpjsks_perusahaan'],
                        "bpjstk_jht_perusahaan" => (empty($row['bpjstk_jht_perusahaan'])) ? 0 : $row['bpjstk_jht_perusahaan'],
                        "bpjstk_jp_perusahaan" => (empty($row['bpjstk_jp_perusahaan'])) ? 0 : $row['bpjstk_jp_perusahaan'],
                        "bpjstk_jkm_perusahaan" => (empty($row['bpjstk_jkm_perusahaan'])) ? 0 : $row['bpjstk_jkm_perusahaan'],
                        "bpjstk_jkk_perusahaan" => (empty($row['bpjstk_jkk_perusahaan'])) ? 0 : $row['bpjstk_jkk_perusahaan'],
                        "gaji_bruto" => (empty($row['gaji_bruto'])) ? 0 : $row['gaji_bruto'],
                        "bpjsks_karyawan" => (empty($row['bpjsks_karyawan'])) ? 0 : $row['bpjsks_karyawan'],
                        "bpjstk_jht_karyawan" => (empty($row['bpjstk_jht_karyawan'])) ? 0 : $row['bpjstk_jht_karyawan'],
                        "bpjstk_jp_karyawan" => (empty($row['bpjstk_jp_karyawan'])) ? 0 : $row['bpjstk_jp_karyawan'],
                        "bpjstk_jkm_karyawan" => (empty($row['bpjstk_jkm_karyawan'])) ? 0 : $row['bpjstk_jkm_karyawan'],
                        "bpjstk_jkk_karyawan" => (empty($row['bpjstk_jkk_karyawan'])) ? 0 : $row['bpjstk_jkk_karyawan'],
                        "pot_sedekah" => (empty($row['pot_sedekah'])) ? 0 : $row['pot_sedekah'],
                        "pot_pkk" => (empty($row['pot_pkk'])) ? 0 : $row['pot_pkk'],
                        "pot_air" => (empty($row['pot_air'])) ? 0 : $row['pot_air'],
                        "pot_rumah" => (empty($row['pot_rumah'])) ? 0 : $row['pot_rumah'],
                        "pot_toko_alif" => (empty($row['pot_toko_alif'])) ? 0 : $row['pot_toko_alif'],
                        "total_potongan" => (empty($row['total_potongan'])) ? 0 : $row['total_potongan'],
                        "pot_tunj_perusahaan" => (empty($row['tunj_bpjs'])) ? 0 : $row['tunj_bpjs'],
                        "thp" => (empty($row['thp'])) ? 0 : $row['thp'],
                        "created_at" => now(),
                        "updated_at" => now(),
                        'cetak_slip' => 0
                    ];
                    PayrollModel::insert($data);
                }
            }
        }
    }
}
