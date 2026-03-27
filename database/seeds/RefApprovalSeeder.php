<?php

use App\Models\HRD\RefApprovalModel;
use Illuminate\Database\Seeder;

class RefApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_dump = array(
            array(
                'id' => 1,
                'group' => "Pengajuan Permintaan Tenaga Kerja"
            ),
            array(
                'id' => 2,
                'group' => "Pengajuan Aplikasi Pelamar"
            ),
            array(
                'id' => 3,
                'group' => "Pengajuan Cuti"
            ),
            array(
                'id' => 4,
                'group' => "Pengajuan Izin"
            ),
            array(
                'id' => 5,
                'group' => "Pengajuan Perubahan Status"
            ),
            array(
                'id' => 6,
                'group' => "Pengajuan Mutasi"
            ),
            array(
                'id' => 7,
                'group' => "Pengajuan Lembur"
            ),
            array(
                'id' => 8,
                'group' => "Pengajuan Perjalanan Dinas"
            ),
            array(
                'id' => 9,
                'group' => "Pengajuan Pelatihan"
            ),
            array(
                'id' => 10,
                'group' => "Pengajuan Surat Teguran"
            ),
            array(
                'id' => 11,
                'group' => "Pengajuan Surat Peringatan "
            ),
            array(
                'id' => 12,
                'group' => "Pengajuan Penggajian"
            ),
            array(
                'id' => 13,
                'group' => "Pengajuan Pinjaman Karyawan"
            ),
            array(
                'id' => 14,
                'group' => "Pengajuan Perubahan Masa Cuti"
            ),
            array(
                'id' => 15,
                'group' => "Pengajuan Resign"
            ),
            array(
                'id' => 16,
                'group' => "Pengajuan Form Exit Interviews"
            ),
            array(
                'id' => 17,
                'group' => "Pengajuan Penonaktifan Surat Peringatan"
            ),
             array(
                'id' => 18,
                'group' => "Pengajuan Tunjangan Hari Raya"
             ),
             array(
                'id' => 19,
                'group' => "Pengajuan KPI Departemen"
            )
        );
        foreach($arr_dump as $item) {
            $datainsert = [
                'id' => $item['id'],
                'ref_group' => $item['group'],
            ];
            RefApprovalModel::updateOrCreate([
                'id' => $item['id']
            ], $datainsert);
        }
    }
}
