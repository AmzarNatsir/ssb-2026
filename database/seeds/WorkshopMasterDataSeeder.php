<?php

use App\Models\Tender\Project;
use App\Models\Warehouse\Brand;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\EquipmentCategory;
use App\Models\Workshop\Location;
use App\Models\Workshop\MasterData\ToolCategory;
use App\Models\Workshop\MasterData\Tools;
use Illuminate\Database\Seeder;

class WorkshopMasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ------ TOOL CATEGORY -----------
        $toolCategories = [
            'Umum', 'Khusus', 'Special', '0-25', '0-75', '50-75', 'Timbang Gardan', 'Digital', 'Sensor', 'Pengukur Tekanan', 'Peluang', 'Penerangan', 'Penerangan', 'Semprot Dico', '8 Inch', '7 kg', '14 kg', '35 kg', '55 kg', 'Besi', 'Karet', 'Stand', '8-10', '10-12', '12-14', '13-17', '14-17', '17-19', '22-24', '24-27', '30-32', '32', '41', '58'];
        
        array_map(function($name){
            $toolCategory = new ToolCategory();
            $toolCategory->name = $name;
            $toolCategory->save();
        }, $toolCategories);

        // --------- END OF TOOL CATEGORY -----------

        // -------- TOOLS ---------------------
        $toolCategories = ToolCategory::pluck('id');
        $locations = ["A3 (Umum)","A2 (Umum)","A2 (Umum)","A2 (Umum)"];

        $tools = [
            ['code' => 'TSA1.A1','name' => 'Mikro'],
            ['code' => 'TSA2.A1','name' => 'Mikro'],
            ['code' => 'TSA3.A1','name' => 'Mikro'],
            ['code' => 'TSA4.A1','name' => 'Freload'],
            ['code' => 'TSA5.A1','name' => 'Apometer'],
            ['code' => 'TSA6.A1','name' => 'RPM'],
            ['code' => 'TSA7.A1','name' => 'Pressure Breker'],
            ['code' => 'TUM1.A1','name' => 'Plong (Set)'],
            ['code' => 'TUM2.A1','name' => 'Senter Kepala'],
            ['code' => 'TUM3.A1','name' => 'Senter Tangan'],
            ['code' => 'TKS1.A2','name' => 'Spoit'],
            ['code' => 'TKS2.A2','name' => 'Sigma'],
            ['code' => 'TUM1.A2','name' => 'Momen'],
            ['code' => 'TUM2.A2','name' => 'Momen'],
            ['code' => 'TUM3.A2','name' => 'Momen'],
            ['code' => 'TUM4.A2','name' => 'Momen'],
            ['code' => 'TUM5.A2','name' => 'Hammer'],
            ['code' => 'TUM6.A2','name' => 'Hammer Karet'],
            ['code' => 'TKS1.A2','name' => 'Handle Tap'],
        ];

        array_map(function($item) use($locations, $toolCategories){
            $tool = new Tools();
            $tool->code = $item['code'];
            $tool->name = $item['name'];
            $tool->qty = rand(0,4);
            $tool->location = $locations[rand(0, (count($locations)) - 1)];
            $tool->tool_category_id = $toolCategories[rand(0, (count($locations)) - 1)];
            $tool->save();
        }, $tools);
        
        // -------- END OF TOOLS ---------------------

        // -------- EQUIPMENT CATEGORY --------------
            $equipmentCategories = [
                ['name'=> 'Bulldozer', 'description'=>'Bulldozer'],
                ['name'=> 'Excavator', 'description'=>'Excavator'],
                ['name'=> 'Dump Truck', 'description'=>'Dump Truck'],
                ['name'=> 'Washer Sluice', 'description'=>'Washer Sluice'],
                ['name'=> 'Fuel Truck', 'description'=>'Fuel Truck'],
            ];

            array_map(function($item){
                $equipmentCategory = new EquipmentCategory();
                $equipmentCategory->name = $item['name'];
                $equipmentCategory->description = $item['description'];
                $equipmentCategory->save();
            }, $equipmentCategories);
                

        // -------- END OF EQUIPMENT CATEGORY --------------

        // -------- EQUIPMENT --------------
        $brandList = [
            'NISSAN',
            'KOMATSU',
            'HINO',
            'CAT',
            'BOMAG'
        ];
        
        $brands = Brand::pluck('id');

        if (count($brands) < 2) {
            array_map(function($item){
                $brand = new Brand();
                $brand->name = $item;
                $brand->description = $item;
                $brand->save();

            }, $brandList);

            $brands = Brand::pluck('id');
        }

        $equipmentCategories = EquipmentCategory::pluck('id');
        $equipments = [
            ['name'=>'BD7', 'code'=>'D3C'],
            ['name'=>'BD31', 'code'=>'D85E-SS-2'],
            ['name'=>'BD35', 'code'=>'D85E-SS-2'],
            ['name'=>'BD36', 'code'=>'D85E-SS-2'],
            ['name'=>'BD37', 'code'=>'D85E-SS-2'],
            ['name'=>'BD40', 'code'=>'D85E-SS-2'],
            ['name'=>'BD41', 'code'=>'D65P-12'],
            ['name'=>'FD1', 'code'=>'FD50E-5'],
            ['name'=>'FD2', 'code'=>'FD50E-5'],
            ['name'=>'FD3', 'code'=>'FD25-11'],
            ['name'=>'GD8', 'code'=>'GD 511A-1'],
            ['name'=>'PC15', 'code'=>'PC200-7'],
            ['name'=>'PC16', 'code'=>'PC200-7 Long Arm'],
            ['name'=>'PC17', 'code'=>'PC200-7'],
            ['name'=>'PC21', 'code'=>'PC200-6'],
            ['name'=>'PC35', 'code'=>'PC200-6'],
            ['name'=>'PC39', 'code'=>'PC200-7'],
            ['name'=>'PC42', 'code'=>'PC200-7'],
            ['name'=>'PC43', 'code'=>'PC200-7'],
            ['name'=>'PC45', 'code'=>'PC300SE-7'],
            ['name'=>'PC47', 'code'=>'PC200-8'],
            ['name'=>'PC50', 'code'=>'PC200-8'],
            ['name'=>'PC51', 'code'=>'PC200-8'],
            ['name'=>'PC53', 'code'=>'PC200-8'],
            ['name'=>'PC55', 'code'=>'PC300SE-8'],
            ['name'=>'PC59', 'code'=>'PC200-8'],
            ['name'=>'PC60', 'code'=>'PC400LC SE-8'],
            ['name'=>'PC61', 'code'=>'PC200-8'],
            ['name'=>'PC62', 'code'=>'PC200-8'],
        ];

        $projects = Project::all();
        if (!$projects->count() > 1) {
            $this->call(ProjectSeeder::class);
            $projects = Project::all();
        }

        $locations = Location::all();
        if (!$locations->count() > 1) {
            $this->call(LocationSeeder::class);
            $locations = Location::all();
        }

        array_map(function($item) use ($equipmentCategories, $brands, $locations, $projects){
            $equipment = new Equipment();
            $equipment->name = $item['name'];
            $equipment->code = $item['code'];
            $equipment->brand_id = $brands[rand(0, count($brands)-1)];
            $equipment->location_id = $locations->random(1)->first()->id;
            $equipment->project_id = $projects->random(1)->first()->id;
            $equipment->yop = rand(2010, 2021);
            $equipment->model = '';
            $equipment->pic = 1;
            $equipment->description = '';
            $equipment->created_by = 1;
            $equipment->updated_by = 1;
            $equipment->hm = rand(1000, 2000);
            $equipment->hm = rand(100, 400);
            $equipment->status = rand(0, count(Equipment::STATUS) - 1);
            $equipment->equipment_category_id = $equipmentCategories[rand(0,count($equipmentCategories)-1)];
            $equipment->save();
        }, $equipments);
        
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


}
