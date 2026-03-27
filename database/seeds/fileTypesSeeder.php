<?php

use Illuminate\Database\Seeder;
use App\Models\Tender\FileTypes;

class FileTypesSeeder extends Seeder
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
                "name" => "undangan pelelangan",
                "file_types_category_id" => 2
            ),
            array(
                "name" => "penawaran harga",
                "file_types_category_id" => 2
            ),
            array(
                "name" => "disposisi",
                "file_types_category_id" => 2
            ),
            array(
                "name" => "laporan survey lokasi",
                "file_types_category_id" => 2
            ),
            array(
                "name" => "scoring",
                "file_types_category_id" => 2
            ),
            array(
                "name" => "pre-analyst",
                "file_types_category_id" => 2
            ),
            array(
                "name" => "TOR",
                "file_types_category_id" => 2
            ),
            array(
                "name" => "laporan audit",
                "file_types_category_id" => 1
            ),
            array(
                "name" => "surat izin usaha",
                "file_types_category_id" => 1
            ),
            array(
                "name" => "NPWP",
                "file_types_category_id" => 1
            ),
            array(
                "name" => "laporan keuangan",
                "file_types_category_id" => 1
            ),
        );
        
        DB:: table('file_types')->truncate();

        foreach ($dump as $value) {
            if(FileTypes::where('name', '<>', $value['name']))
            {
                FileTypes::create([
                    'name' => $value['name'],
                    'file_types_category_id' => $value['file_types_category_id']
                ]);             
            }            
        }
    }
}
