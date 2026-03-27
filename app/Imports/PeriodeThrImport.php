<?php

namespace App\Imports;

use App\Models\HRD\ThrDetailModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeriodeThrImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    protected $id_head;

    public function __construct(string $id_head)
    {
        $this->id_head = $id_head;
    }

    public function collection(Collection $row)
    {
        foreach($row as $row) {
            if(!empty($row["id_karyawan"])) {
                $dataExisting = ThrDetailModel::where('id_karyawan', $row["id_karyawan"])
                        ->where('bulan', $row["bulan"])
                        ->where('tahun', $row["tahun"])->count();
                if($dataExisting==0) {
                    $data = [
                        "id_karyawan" => $row["id_karyawan"],
                        "id_departemen" => $row["id_departemen"],
                        "id_head" => $this->id_head,
                        "bulan" => $row["bulan"],
                        "tahun" => $row["tahun"],
                        "gaji_pokok" => (empty($row['gaji_pokok'])) ? 0 : $row['gaji_pokok'],
                        "tunj_tetap" => (empty($row['tunj_tetap'])) ? 0 : $row['tunj_tetap'],
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];
                    ThrDetailModel::insert($data);
                }
            }
        }
    }
}
