<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Address\Vendor::class, function (Faker $faker) {

    return [
        'name' => $faker->name
    ];
});
