<?php

use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Category;
use App\Models\Warehouse\SparePart;
use App\Models\Warehouse\Supplier;
use App\Models\Warehouse\Uop;
use Illuminate\Database\Seeder;

class WarehouseMasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uops = [
            [
                'name' => 'KG',
                'description' => 'Kilogram'
            ],
            [
                'name' => 'CM',
                'description' => 'Centimeter',
            ],
            [
                'name' => 'SET',
                'description' => 'Set'
            ],
            [
                'name' => 'PCS',
                'description' => 'Pieces'
            ]
        ];

        if (!count(Uop::all())) {
            Uop::insert($uops);
        }

        if (!Brand::all()->count()) {
            $this->call(BrandSeeder::class);
        }

        if(!Supplier::all()->count()){
            $this->call(SupplierSeeder::class);
        }

        $sparePartCategories = [
            [
                'name' => 'SPARE PART',
                'description' => 'Spare part'
            ],
            [
                'name' => 'CONSUMABLE',
                'description' => 'Consumable'
            ]
        ];

        if (!Category::all()->count()) {
            Category::insert($sparePartCategories);
        }

        factory(SparePart::class,20)->create();

    }
}
