<?php

use Illuminate\Database\Seeder;

class KomiteTypesSeeder extends Seeder
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
                "name" => "pre analyst",
            ),
            array(
                "name" => "project",
            )
        );
        
        foreach ($dump as $value) {
            # code...
            DB::table('komite_types')->insert([
                'name' => $value['name'] 
            ]);
        }
    }
}
