<?php

use Illuminate\Database\Seeder;
use App\Models\Tender\Project;
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = $projects = array(            
            array(
                "number" => "0115/PRO-SSB/XII/2021",
                "name" => "PROJECT SEWA EXCAVATOR",
                "desc" => NULL,
                "source" => "antam",
                "start_date" => NULL,
                "end_date" => NULL,
                "status_id" => 1,
                "tipe_id" => 1,
                "value" => 50000000.00,
                "customer_id" => 4,
                "category_id" => 1,
                "is_tender" => NULL,
                "target_tender_id" => "1",
                "jenis_project_id" => 2,
                "location" => "antam",
                "duration_in_month" => NULL,
                "created_by" => 2,
                "updated_by" => 2,
                "created_at" => "2021-10-05 19:12:32",
                "updated_at" => "2021-10-15 18:50:03",
            ),
            array(
                "number" => "0116/PRO-SSB/XII/2021",
                "name" => "PROJECT SEWA DUMPTRUCK",
                "desc" => "Test inputan",
                "source" => "antam",
                "start_date" => "2021-12-20",
                "end_date" => "2022-12-16",
                "status_id" => 4,
                "tipe_id" => 1,
                "value" => 10000000.00,
                "customer_id" => 4,
                "category_id" => 1,
                "is_tender" => NULL,
                "target_tender_id" => "1",
                "jenis_project_id" => 2,
                "location" => "antam",
                "duration_in_month" => NULL,
                "created_by" => 2,
                "updated_by" => NULL,
                "created_at" => "2021-10-16 14:55:31",
                "updated_at" => "2021-10-16 15:25:07",
            ),
        );

        DB:: table('projects')->truncate();

		foreach ($dump as $value) {
			if (!Project::where('number', '=', $value['number'])->exists()) {
			   Project::create([                
                "number" => $value['number'],
                "name" => $value['name'],
                "desc" => $value['desc'],
                "source" => $value['source'],
                "start_date" => $value['start_date'],
                "end_date" => $value['end_date'],
                "status_id" => $value['status_id'],
                "tipe_id" => $value['tipe_id'],
                "value" => $value['value'],
                "customer_id" => $value['customer_id'],
                "category_id" => $value['category_id'],
                "is_tender" => $value['is_tender'],
                "target_tender_id" => $value['target_tender_id'],
                "jenis_project_id" => $value['jenis_project_id'],
                "location" => $value['location'],
                "duration_in_month" => $value['duration_in_month'],
                "created_by" => $value['created_by'],
                "updated_by" => $value['updated_by'],
                "created_at" => $value['created_at'],
                "updated_at" => $value['updated_at']
			   ]);
			}
		}

        
    }
}
