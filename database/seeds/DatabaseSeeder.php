<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(HRDMasterLevelJabatanSeeder::class);
        $this->call(MasterStatusKaryawanSeeder::class);
        $this->call(OpsiStatusProjectSeeder::class);        
        $this->call(FileTypesCategorySeeder::class);
        $this->call(FileTypesSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(EquipmentCategorySeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(EquipmentStatusSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(InspectionItemSeeder::class);
        $this->call(InspectionPropertiesSeeder::class);
        $this->call(InspectionPropertiesInputSeeder::class);        
    }
}
