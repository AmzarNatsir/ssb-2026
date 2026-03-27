<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpsiTipeProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(
            array(
                "keterangan" => "prakualifikasi",
            ),
            array(
                "keterangan" => "non prakualifikasi",
            ),
            array(
                "keterangan" => "penunjukkan langsung",
            ),
            array(
                "keterangan" => "pemilihan langsung",
            ),
        );

        foreach ($dump as $value) {
            # code...
            DB::table('opsi_tipe_project')->insert([
                'keterangan' => $value['keterangan'] 
            ]);
        }
    }
}
