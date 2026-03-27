<?php

namespace App\Imports;

use App\Models\HRD\AbsensiModel;
use App\Models\HRD\KaryawanModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensiImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!empty($row["nik_lama"])) {
            $getDept = KaryawanModel::where('nik_lama', $row["nik_lama"])->first();
            if(!empty($getDept->id_departemen))
            {
                // dd($row);
                $tanggal_scan = $row['tanggal'];
                $temp_waktu_scan = $row['jam'];
                return new AbsensiModel([
                    "id_departemen" => $getDept->id_departemen,
                    "nik_lama" => $row['nik_lama'],
                    "tanggal" => $tanggal_scan, //$row['tglwaktu'],
                    "jam" => $temp_waktu_scan, //$row['tglwaktu'],
                    "status" => $row['i_o'],
                    "lokasi_id" => $row['lokasi_id'],
                    "user_id" => auth()->user()->id,
                    "dhuhur" => $row['dhuhur'],
                    'ashar' => $row['ashar']
                ]);
            }
        }
    }

}
