<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpsiKategoriProjectSeeder extends Seeder
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
                "keterangan" => "Project Baru",
            ),
            array(
                "keterangan" => "Project Lanjutan",
            ),
            array(
                "keterangan" => "Project Langsung",
            ),
        );
        
        foreach ($dump as $value) {
            # code...
            DB::table('opsi_kategori_project')->insert([
                'keterangan' => $value['keterangan'] 
            ]);
        }
    }
}
