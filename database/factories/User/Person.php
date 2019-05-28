<?php

use App\Models\User\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {

    return [
        'additional_name' => $faker->name,
        'given_name' => $faker->name,
        'family_name' => $faker->name,
        'email' => $faker->email,
    ];
});
