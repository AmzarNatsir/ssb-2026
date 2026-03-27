<?php

namespace App\Imports;

use App\Models\HRD\KaryawanModel;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class KaryawanImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new KaryawanModel(
        [
            "nik_auto" => 1,
            "tgl_masuk" => $row['tgl_masuk'],
            "nik_lama" => $row['nik_lama'],
            "nik" => $row['nik'],
            "nm_lengkap" => $row['nama_lengkap'],
            "tmp_lahir" => $row['tmp_lahir'],
            "tgl_lahir" => $row['tgl_lahir'],
            "jenkel" => $row['jenkel'],
            "no_ktp" => $row['no_ktp'],
            "alamat" => $row['alamat'],
            "notelp" => $row['notelp'],
            "nmemail" => $row['nmemail'],
            "suku" => $row['suku'],
            "agama" => $row['agama'],
            "pendidikan_akhir" => $row['pendidikan_akhir'],
            "status_nikah" => $row['status_nikah'],
            "no_npwp" => $row['no_npwp'],
            "no_bpjstk" => $row['no_bpjstk'],
            "no_bpjsks" => $row['no_bpjsks'],
            "id_status_karyawan" => $row['id_status_karyawan'],
            "id_divisi" => $row['id_divisi'],
            "id_departemen" => $row['id_departemen'],
            "id_subdepartemen" => $row['id_subdepartemen'],
            "id_jabatan" => $row['id_jabatan'],
            "jabatan_awal" => $row['id_jabatan']
        ]);
    }
}
