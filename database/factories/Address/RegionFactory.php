<?php

use App\Models\Address\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];

});
