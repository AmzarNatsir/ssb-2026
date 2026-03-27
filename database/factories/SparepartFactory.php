<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Category;
use App\Models\Warehouse\SparePart;
use App\Models\Warehouse\Uop;
use Faker\Generator as Faker;

$factory->define(SparePart::class, function (Faker $faker) {
    return [
        'part_number' => $faker->swiftBicNumber,
        'interchange' => '',
        'part_name' => $faker->numerify('SP####'),
        'brand_id' => Brand::all()->random(1)->first()->id,
        'uop_id' => Uop::all()->random(1)->first()->id,
        'category_id' => Category::all()->random(1)->first()->id,
        'price' => $faker->numberBetween(50000,1000000),
        'rack' => 'A1',
        'location' => $faker->regexify('[A-Z][0-9]-[0-9]'),
        'used_for' => '',
        'min_stock' => $faker->numberBetween(0,100),
        'max_stock' => $faker->numberBetween(100,200),
        'stock' => $faker->numberBetween(0,100),
        'weight' => $faker->numberBetween(1,10),
        'is_geniune' => rand(0,1),
        'user_id' => 1
    ];
});
