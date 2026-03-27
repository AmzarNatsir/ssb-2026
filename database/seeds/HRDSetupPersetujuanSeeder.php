<?php

use Illuminate\Database\Seeder;
use App\Models\HRD\SetupPersetujuanModel;

class HRDSetupPersetujuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_data = array(
            array("id" => 1, "modul" => "Modul Pengajuan Cuti"),
            array("id" => 2, "modul" => "Modul Pengajuan Recruitment"),
            array("id" => 3, "modul" => "Modul Pengajuan Perubahan Status"),
            array("id" => 4, "modul" => "Modul Pengajuan Mutasi Rotasi"),
            array("id" => 5, "modul" => "Modul Pengajuan Perjalanan Dinas"),
            array("id" => 6, "modul" => "Modul Pengajuan Pelatihan"),
            array("id" => 7, "modul" => "Modul Pengajuan Permintaan Tenaga Kerja"),
            array("id" => 8, "modul" => "Modul Pengajuan Izin")
        );
        foreach($arr_data as $key => $value)
        {
            $id_data = $value['id'];
            $nm_modul = $value['modul'];
            $res_data = SetupPersetujuanModel::where('id', $id_data)->first();
            if(empty($res_data))
            {
                $baru = new SetupPersetujuanModel();
                $baru->id = $id_data;
                $baru->modul = $nm_modul;
                $baru->save();
            }
        }
    }
}
