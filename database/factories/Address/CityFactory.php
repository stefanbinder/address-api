<?php

use App\Models\Address\City;
use App\Models\Address\Country;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {

    $countries = Country::all();

    if( !$countries->count() ) {
        $countries = factory(Country::class, 3)->create();
    }

    return [
        'name' => $faker->name,
        'country_id' => $countries->random()->id
    ];

});
