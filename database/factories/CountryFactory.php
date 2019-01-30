<?php

use App\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code2' => $faker->randomLetter.$faker->randomLetter,
        'code3' => $faker->randomLetter.$faker->randomLetter.$faker->randomLetter,
    ];
});
