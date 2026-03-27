<?php

use Illuminate\Database\Seeder;
use App\Models\Workshop\EquipmentCategory;


class EquipmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(
        	array("name" => "barge"),
			array("name" => "bulldozer"),
			array("name" => "compactor"),
			array("name" => "compressor"),
			array("name" => "crusher"),			
			array("name" => "dump truck"),
			array("name" => "engine utility"),			
			array("name" => "excavator"),
			array("name" => "forklift"),
			array("name" => "fuel truck"),
			array("name" => "generator set"),
			array("name" => "light vehicle"),
			array("name" => "man hauler/bus"),
			array("name" => "mixer truck"),
			array("name" => "motor grader"),
			array("name" => "tronton"),
			array("name" => "truck ringan (3/4)"),
			array("name" => "tug boat"),
			array("name" => "water truck"),
			array("name" => "wheel loader")			
        );

        foreach ($dump as $value) {
        	if (!EquipmentCategory::where('name', '=', $value['name'])->exists()) {
			   EquipmentCategory::create([
			   	'name' => $value['name']
			   ]);
			}
        }
    }
}
