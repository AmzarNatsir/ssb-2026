<?php

use Illuminate\Database\Seeder;
use App\Models\Hse\InspectionItem;

class InspectionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(
            array("name" => "daily checklist"),
            array("name" => "pre check indicator"),
            array("name" => "check indicator"),
            array("name" => "pemeriksaan lanjutan kerusakan")
        );

        DB:: table('inspection_item')->truncate();

		foreach ($dump as $value) {
			if (!InspectionItem::where('name', '=', $value['name'])->exists()) {
                InspectionItem::create([
                    'name' => $value['name']
			    ]);
			}
		}
    }
}
