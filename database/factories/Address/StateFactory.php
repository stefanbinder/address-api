<?php

use App\Models\Address\State;
use Faker\Generator as Faker;

$factory->define(State::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});
