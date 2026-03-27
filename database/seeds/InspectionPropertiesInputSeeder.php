<?php

use Illuminate\Database\Seeder;
use App\Models\Hse\InspectionPropertiesInput;

class InspectionPropertiesInputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(
            array('type' => 'text'),
            array('type' => 'option'),
            array('type' => 'optionGroup'),
            array('type' => 'date'),
            array('type' => 'number')
        );

        DB:: table('inspection_properties_input')->truncate();

		foreach ($dump as $value) {
			if (!InspectionPropertiesInput::where('type', '=', $value['type'])->exists()) {
                InspectionPropertiesInput::create([
                    'type' => $value['type']
			    ]);
			}
		}
    }
}
