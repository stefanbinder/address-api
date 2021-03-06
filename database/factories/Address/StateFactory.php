<?php

use App\Models\Address\Country;
use App\Models\Address\State;
use Faker\Generator as Faker;

$factory->define(State::class, function (Faker $faker) {

    $countries = Country::all();

    if( !$countries->count() ) {
        $countries = factory(Country::class, 3)->create();
    }

    return [
        'name' => $faker->name,
        'country_id' => $countries->random()->id,
    ];
});
