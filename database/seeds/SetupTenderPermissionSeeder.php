<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SetupTenderPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(
            array("name" => "project.view"),
            array("name" => "project.create"),
            array("name" => "project.update"),
            array("name" => "project.delete"),
            array("name" => "survey.view"),
            array("name" => "survey.create"),
            array("name" => "survey.update"),
            array("name" => "survey.delete"),
            array("name" => "survey.update")
        );

        foreach ($dump as $value) {                        
            
            if(is_null(Permission::where('name', $value['name'])->first()))
            {                
                Permission::create([
                    'name' => $value['name']
                ]);
            }
            
        }
        
    }
}
