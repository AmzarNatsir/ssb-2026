<?php

namespace App\Imports;

use App\Models\HRD\KaryawanModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IDFingerKaryawanImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $row)
    {
        foreach($row as $row) {
            $update = KaryawanModel::find($row['id']);
            $update->id_finger = $row['id_finger'];
            $update->save();
        }
    }
    // public function model(array $row)
    // {
        // return new TempfimgerModel(
        //     [
        //         "id" => $row['id'],
        //         "id_finger" => $row['id_finger']
        //     ]
        //     );
    // }
}
