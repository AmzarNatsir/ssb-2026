<?php

use Illuminate\Database\Seeder;
use App\Models\HRD\StatusKaryawanModel;

class MasterStatusKaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_data = array(
            array('id' => 1, 'nm_status' => "Training", "keterangan" => "Status Traning", "status" => 1),
            array('id' => 2, 'nm_status' => "Kontrak", "keterangan" => "Status Kontrak", "status" => 1),
            array('id' => 3, 'nm_status' => "Tetap", "keterangan" => "Status Tetap", "status" => 1),
            array('id' => 4, 'nm_status' => "Resign", "keterangan" => "Status Resign", "status" => 1),
            array('id' => 5, 'nm_status' => "PHK", "keterangan" => "Status PHK", "status" => 1),
            array('id' => 6, 'nm_status' => "Pensiun", "keterangan" => "Status Pensiun", "status" => 1),
            array('id' => 7, 'nm_status' => "Harian", "keterangan" => "Status Harian", "status" => 1)
            
        );
        foreach($arr_data as $key => $value)
        {
            $id_data = $value['id'];
            $res_data = StatusKaryawanModel::where('id', $id_data)->first();
            if(empty($res_data))
            {
                $baru = new StatusKaryawanModel();
                $baru->id = $id_data;
                $baru->nm_status = $value['nm_status'];
                $baru->keterangan = $value['keterangan'];
                $baru->status = $value['status'];
                $baru->save();
            }
        }
    }
}
