<?php

use App\Models\Warehouse\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'name' => 'PT. Sinar Surya Lestari',
                'address' => 'Komplek Ruko Golden Ville No 88 CJ JL.Taman Daan Mogot, Kebon Jeruk, Jakarta Barat Jakarta 11510, Jakarta Barat, Jakarta, Indonesia',
                'active' => true
            ],
            [
                'name' => 'Plarad Indonesia',
                'address' => 'Shophouse Casa De Parco No.07 BSD City Kelurahan Sampora, Kecamatan Cisauk, Kab. Tangerang, Tangerang, Indonesia',
                'active' => true
            ],
            [
                'name' => 'PT. Mandiri Indonusa Perkasa',
                'address' => 'WTC Mangga Dua Lt. Ground Blok A No.34, 35,37 Jl. Mangga Dua Raya No.8 Jakarta Utara, Jakarta Utara, Jakarta, Indonesia',
                'active' => true
            ],
            [
                'name' => 'PT. Supreme Jaya Abadi',
                'address' => 'Jl. Kapuk Raya, Komplek. Nusa Indah No.6, Jakarta Barat., Jakarta Barat, Jakarta, Indonesia',
                'active' => true
            ],
            [
                'name' => 'PT. Gaya Makmur Mobil',
                'address' => 'Jl. Lkr. Luar Barat No.9, RT.14/RW.14, Rawa Buaya, Kecamatan Cengkareng, Jakarta Barat, Jakarta, Indonesia',
                'active' => true
            ],
            [
                'name' => 'PT Adhireksa Inticor',
                'address' => 'Jl. Bendungan Hilir Raya GII No.13, Jakarta Pusat, Jakarta, Indonesia',
                'active' => true
            ]
        ];

        array_map(function($item){
            Supplier::create($item);
        }, $suppliers);
    }
}
