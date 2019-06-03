<?php

use App\Models\Address\Country;
use App\Models\Address\Region;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {

    $regions = Region::all();

    if( !$regions->count() ) {
        $regions = factory(Region::class, 3)->create();
    }

    return [
        'name' => $faker->name,
        'code2' => $faker->randomLetter.$faker->randomLetter,
        'code3' => $faker->randomLetter.$faker->randomLetter.$faker->randomLetter,
        'region_id' => $regions->random()->id
    ];
});
