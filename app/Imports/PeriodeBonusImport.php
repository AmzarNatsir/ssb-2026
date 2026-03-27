<?php

namespace App\Imports;

use App\Models\HRD\BonusDetailModel;
use App\Models\HRD\PayrollModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeriodeBonusImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $row)
    {
        foreach($row as $row) {
            if(!empty($row["id_karyawan"])) {
                $dataExisting = BonusDetailModel::where('id_karyawan', $row["id_karyawan"])
                        ->where('bulan', $row["bulan"])
                        ->where('tahun', $row["tahun"])->count();
                if($dataExisting==0) {
                    $data = [
                        "id_karyawan" => $row["id_karyawan"],
                        "id_departemen" => $row["id_departemen"],
                        "bulan" => $row["bulan"],
                        "tahun" => $row["tahun"],
                        "gaji_pokok" => (empty($row['gaji_pokok'])) ? 0 : $row['gaji_pokok'],
                        "bonus" => (empty($row['bonus'])) ? 0 : $row['bonus'],
                        "lembur" => (empty($row['lembur'])) ? 0 : $row['lembur'],
                        "created_at" => now(),
                        "updated_at" => now(),
                        'cetak_slip' => 0
                    ];
                    BonusDetailModel::insert($data);
                }
            }
        }
    }
}
