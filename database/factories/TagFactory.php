<?php

use App\Models\Address\Country;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(\App\Models\Tag::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});
