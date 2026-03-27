<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpsiStatusProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(
            array("keterangan" => "registrasi"),
            array("keterangan" => "analisa"),
            array("keterangan" => "prakualifikasi"),
            array("keterangan" => "aktif"),
            array("keterangan" => "close"),
        );

        DB::table('opsi_status_project')->truncate();

        foreach ($dump as $value) {
            # code...
            DB::table('opsi_status_project')->insert([
                'keterangan' => $value['keterangan'] 
            ]);
        }
        
    }
}
