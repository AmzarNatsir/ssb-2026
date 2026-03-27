<?php

use Illuminate\Database\Seeder;
use App\Models\Workshop\EquipmentStatus;
class EquipmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('equipment_status')->truncate();
        $dump = array(
            array("name" => "active"),
            array("name" => "inactive"),
            array("name" => "scrap"),
            array("name" => "sold"),
            array("name" => "under maintenance")
        );

        foreach ($dump as $value) {
			if (!EquipmentStatus::where('name', '=', $value['name'])->exists()) {
                EquipmentStatus::create([			   	
			   	    'name' => $value['name']
			    ]);
			}
		}
    }
}
