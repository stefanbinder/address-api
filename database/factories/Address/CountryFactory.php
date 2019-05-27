<?php

use App\Models\Address\Country;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'code' => $faker->randomLetter.$faker->randomLetter,
        'inhabitants' => $faker->numberBetween(2000, 1000000),
        'founded_at' => $faker->date(),
        'last_visited' => $faker->date(),
        'president_id' => null,
    ];
});
