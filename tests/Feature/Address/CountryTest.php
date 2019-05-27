<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use Tests\Feature\DefaultEndpointsHelper;

class CountryTest extends DefaultEndpointsHelper
{
    public function assertAttributes($attributes, $testAttributes)
    {
        self::assertEquals($attributes['name'], $testAttributes['name']);
        self::assertEquals($attributes['code'], $testAttributes['code']);
        self::assertEquals($attributes['inhabitants'], $testAttributes['inhabitants']);
        self::assertEquals((string)$attributes['founded_at'], $testAttributes['founded_at']);
        self::assertEquals((string)$attributes['last_visited'], $testAttributes['last_visited']);
    }

    public function getModel()
    {
        return Country::class;
    }

    public function getEndpoint()
    {
        return '/api/countries/';
    }
}
