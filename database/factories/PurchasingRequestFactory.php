<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Warehouse\PurchasingRequest;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(PurchasingRequest::class, function (Faker $faker) {
    return [
        'number' => $faker->randomNumber(),
        'purchasing_type' => $faker->numberBetween(1,3),
        'reference_id' => null,
        'remarks' => $faker->text(),
        'created_by'=> Arr::random(\App\User::pluck('id')->toArray()),
    ];
});
