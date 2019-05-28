<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Address\State;
use Tests\Feature\RelatedEndpointsHelper;

class CountryRelatedStateTest extends RelatedEndpointsHelper
{

    protected $country;

    protected function setUp(): void
    {
        parent::setUp();

        $this->country = factory(Country::class)->create();
    }

    public function assertAttributes($attributes, $testAttributes)
    {
        self::assertEquals($attributes['name'], $testAttributes['name']);
    }

    public function getModel()
    {
        return State::class;
    }

    public function getEndpoint()
    {
        return '/api/countries/' . $this->country->id . '/states/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        return factory(State::class)->$factoryMethod([
            'country_id' => $this->country->id
        ]);
    }
}
