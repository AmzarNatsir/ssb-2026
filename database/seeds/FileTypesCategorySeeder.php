<?php

use Illuminate\Database\Seeder;
use App\Models\Tender\FileTypesCategory;

class FileTypesCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $dump = array(
        //     array("name" => "legalitas perusahaan"),
        //     array("name" => "laporan audit & keuangan"),
        //     array("name" => "project"),
        //     array("name" => "lelang")            
        // );

        $dump = array(
            array("name" => "fixed document"),
            array("name" => "non fixed document")
        );

        DB:: table('file_types_category')->truncate();

        foreach ($dump as $value) {	        	        

	        if(FileTypesCategory::where('name', '<>', $value['name']))
	        {
	        	FileTypesCategory::create([
	        		'name' => $value['name']
	        	]);	            
	        }                        
        }
    }
}
