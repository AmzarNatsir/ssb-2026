<?php

use Illuminate\Database\Seeder;
use App\Models\HRD\LevelJabatanModel;

class HRDMasterLevelJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_data = array(
            array('id' => 1, 'nm_level' => "Komisaris", "sts_dept" => 1, "sts_subdept" => 1, "sts_gakom"=>1, "sts_gakor"=>1, "status"=>1, "level"=>0),
            array('id' => 2, 'nm_level' => "Direksi", "sts_dept" => 1, "sts_subdept" => 1, "sts_gakom"=>1, "sts_gakor"=>1, "status"=>1, "level"=>1),
            array('id' => 3, 'nm_level' => "Divisi", "sts_dept" => 1, "sts_subdept" => 1, "sts_gakom"=>1, "sts_gakor"=>1, "status"=>1, "level"=>2),
            array('id' => 4, 'nm_level' => "Departemen", "sts_dept" => 1, "sts_subdept" => 1, "sts_gakom"=>1, "sts_gakor"=>1, "status"=>1, "level"=>3),
            array('id' => 5, 'nm_level' => "Bagian/Seksi", "sts_dept" => 1, "sts_subdept" => 1, "sts_gakom"=>1, "sts_gakor"=>1, "status"=>1, "level"=>4),
            array('id' => 6, 'nm_level' => "Staf", "sts_dept" => 1, "sts_subdept" => 1, "sts_gakom"=>1, "sts_gakor"=>1, "status"=>1, "level"=>5)

        );
        foreach($arr_data as $key => $value)
        {
            $id_data = $value['id'];
            $res_data = LevelJabatanModel::where('id', $id_data)->first();
            if(empty($res_data))
            {
                $baru = new LevelJabatanModel();
                $baru->id = $id_data;
                $baru->nm_level = $value['nm_level'];
                $baru->sts_dept = $value['sts_dept'];
                $baru->sts_subdept = $value['sts_subdept'];
                $baru->sts_gakom = $value['sts_gakom'];
                $baru->sts_gakor = $value['sts_gakor'];
                $baru->status = $value['status'];
                $baru->level = $value['level'];
                $baru->save();
            }
        }
    }
}
