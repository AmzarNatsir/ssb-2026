<?php

use Illuminate\Database\Seeder;
use App\Models\Workshop\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $dump = array(
            array('location_name'=>'sumber latumbi pomalaa'),
            array('location_name'=>'workshop pomalaa'),
            array('location_name'=>'qc. antam pomalaa (p17-013)'),
            array('location_name'=>'rekling antam tambang selatan (p18-022)'),
            array('location_name'=>'qc. antam leppe (p17-013)'),
            array('location_name'=>'sumber batu raja sopura'),
            array('location_name'=>'x21.c-078 (project supporting)'),
            array('location_name'=>'pt. bkm (p21-056)'),
            array('location_name'=>'x21.c-076-2 (project supporting)'),
            array('location_name'=>'perawatan jalan antam pomalaa (p17-014)'),
        );

        DB:: table('location')->truncate();

		foreach ($dump as $value) {
			if (!Location::where('location_name', '=', $value['location_name'])->exists()) {
                Location::create([
			   	'location_name' => $value['location_name']
			   ]);
			}
		}
    }
}
