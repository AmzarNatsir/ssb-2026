<?php

namespace App\Imports;

use App\Models\HRD\KaryawanModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GapokEImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $row)
    {
        foreach($row as $row) {
            if(!empty($row["id"])) {
                $gapok = (empty($row['gaji_pokok'])) ? 0 : $row['gaji_pokok'];
                $bpjs = (empty($row['bpjs'])) ? 0 : $row['bpjs'];
                $jamsostek = (empty($row['jamsostek'])) ? 0 : $row['jamsostek'];
                $update = KaryawanModel::find($row['id']);
                $update->gaji_pokok = $gapok;
                $update->gaji_bpjs = $bpjs;
                $update->gaji_jamsostek = $jamsostek;
                $update->save();
            }
        }
    }
}
