<?php

namespace App\Imports;

use App\Models\HRD\KaryawanModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Config;
use App\Models\HRD\DivisiModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\SubDepartemenModel;
use App\Models\HRD\JabatanModel;

class KaryawanUpsertImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        $divisi_ids = DivisiModel::pluck('id')->toArray();
        $dept_ids = DepartemenModel::pluck('id')->toArray();
        $subdept_ids = SubDepartemenModel::pluck('id')->toArray();
        $jabatan_ids = JabatanModel::pluck('id')->toArray();
        $agama_keys = array_keys(Config::get("constants.agama") ?? []);
        $pendidikan_keys = array_keys(Config::get("constants.jenjang_pendidikan") ?? []);
        $status_nikah_keys = array_keys(Config::get("constants.status_pernikahan") ?? []);
        $status_karyawan_keys = array_keys(Config::get("constants.status_karyawan") ?? []);

        foreach ($rows as $row) {
            // Re-validate to be absolutely sure
            if (empty($row['nik'])) continue;

            $isValid = true;

            $tgl_masuk = $row['tanggal_masuk'] ?? null;
            $tgl_lahir = $row['tanggal_lahir'] ?? null;

            if (is_numeric($tgl_masuk)) {
                try {
                    $tgl_masuk = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tgl_masuk)->format('Y-m-d');
                } catch (\Exception $e) {}
            }
            if (is_numeric($tgl_lahir)) {
                try {
                    $tgl_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tgl_lahir)->format('Y-m-d');
                } catch (\Exception $e) {}
            }

            $jenkel = $row['jenis_kelamin_id'] ?? null;
            $agama = $row['agama_id'] ?? null;
            $pendidikan_akhir = $row['pendidikan_akhir_id'] ?? null;
            $status_nikah = $row['status_pernikahan_id'] ?? null;
            $id_status_karyawan = $row['status_akryawan_id'] ?? null;
            $id_divisi = $row['divisi_id'] ?? null;
            $id_departemen = $row['departemen_id'] ?? null;
            $id_subdepartemen = $row['sub_departemen_id'] ?? null;
            $id_jabatan = $row['jabatan_id'] ?? null;

            if (!empty($tgl_masuk) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $tgl_masuk)) { $isValid = false; }
            if (!empty($tgl_lahir) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $tgl_lahir)) { $isValid = false; }
            if (!empty($jenkel) && !in_array($jenkel, [1, 2])) { $isValid = false; }
            if (!empty($agama) && !in_array($agama, $agama_keys)) { $isValid = false; }
            if (!empty($pendidikan_akhir) && !in_array($pendidikan_akhir, $pendidikan_keys)) { $isValid = false; }
            if (!empty($status_nikah) && !in_array($status_nikah, $status_nikah_keys)) { $isValid = false; }
            if (!empty($id_status_karyawan) && !in_array($id_status_karyawan, $status_karyawan_keys)) { $isValid = false; }
            if (!empty($id_divisi) && !in_array($id_divisi, $divisi_ids) && $id_divisi != 0) { $isValid = false; }
            if (!empty($id_departemen) && !in_array($id_departemen, $dept_ids) && $id_departemen != 0) { $isValid = false; }
            if (!empty($id_subdepartemen) && !in_array($id_subdepartemen, $subdept_ids) && $id_subdepartemen != 0) { $isValid = false; }
            if (!empty($id_jabatan) && !in_array($id_jabatan, $jabatan_ids) && $id_jabatan != 0) { $isValid = false; }

            if ($isValid) {
                KaryawanModel::updateOrCreate(
                    ['nik' => $row['nik']],
                    [
                        "nik_auto" => 1,
                        "tgl_masuk" => $tgl_masuk,
                        "nik_lama" => $row['nik_lama'] ?? null,
                        "nm_lengkap" => $row['nama_lengkap'] ?? null,
                        "tmp_lahir" => $row['tempat_lahir'] ?? null,
                        "tgl_lahir" => $tgl_lahir,
                        "jenkel" => $jenkel,
                        "no_ktp" => $row['no_ktp'] ?? null,
                        "alamat" => $row['alamat'] ?? null,
                        "notelp" => $row['no_telepon'] ?? null,
                        "nmemail" => $row['email'] ?? null,
                        "suku" => $row['suku'] ?? null,
                        "agama" => $agama,
                        "pendidikan_akhir" => $pendidikan_akhir,
                        "status_nikah" => $status_nikah,
                        "no_npwp" => $row['no_npwp'] ?? null,
                        "no_bpjstk" => $row['no_bpjs_tk'] ?? null,
                        "no_bpjsks" => $row['no_bpjs_ks'] ?? null,
                        "id_status_karyawan" => $id_status_karyawan,
                        "id_divisi" => $id_divisi,
                        "id_departemen" => $id_departemen,
                        "id_subdepartemen" => $id_subdepartemen,
                        "id_jabatan" => $id_jabatan,
                        "jabatan_awal" => $id_jabatan
                    ]
                );
            }
        }
    }
}
