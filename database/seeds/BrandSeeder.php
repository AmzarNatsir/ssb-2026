<?php

use Illuminate\Database\Seeder;
use App\Models\Warehouse\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(        	
        	array("name" => "AIRMAN", "description" => ""),
			array("name" => "ALDO", "description" => ""),
			array("name" => "BITELLI", "description" => ""),
			array("name" => "CAT", "description" => ""),
			array("name" => "DAINICHI", "description" => ""),
			array("name" => "DENYO", "description" => ""),
			array("name" => "FORD", "description" => ""),
			array("name" => "GOLDRAT", "description" => ""),
			array("name" => "HINO", "description" => ""),
			array("name" => "JIANG DONG", "description" => ""),			
			array("name" => "KOBELCO", "description" => ""),
			array("name" => "KOMATSU", "description" => ""),
			array("name" => "KRISBOW", "description" => ""),
			array("name" => "KUBOTA", "description" => ""),
			array("name" => "MATSUURA", "description" => ""), 
			array("name" => "MEUSER & CO", "description" => ""),
			array("name" => "MITSUBISHI", "description" => ""),
			array("name" => "NISSAN", "description" => ""),
			array("name" => "RHINO", "description" => ""),
			array("name" => "SANCHIN SVN-30", "description" => ""),
			array("name" => "SHARK", "description" => ""),
			array("name" => "SHARK YANMAR", "description" => ""),			
			array("name" => "TOYOTA", "description" => ""),
			array("name" => "WELDING", "description" => ""),
			array("name" => "YAMAZAKI", "description" => ""),
			array("name" => "YANMAR", "description" => "")
        );

        foreach ($dump as $key => $value) {
        	// if (!Brand::where('name', '=', $value['name'])->exists()) {        	
        	if(empty(Brand::where('name', $value['name'])->first()))
        	{
			   Brand::create([
			   	'name' => $value['name'],
			   	'description' => $value['description']
			   ]);
			}
        }
    }
}
