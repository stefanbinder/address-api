<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\User;
use App\Models\User\Person;
use Tests\Feature\RelatedEndpointsHelper;

class CountryRelatedPresidentTest extends RelatedEndpointsHelper
{

    protected $country;
    protected $president;

    protected function setUp(): void
    {
        parent::setUp();

        $this->country = factory(Country::class)->create();
    }

    public function assertAttributes($attributes, $testAttributes)
    {
        self::assertEquals($attributes['additional_name'], $testAttributes['additional_name']);
        self::assertEquals($attributes['given_name'], $testAttributes['given_name']);
        self::assertEquals($attributes['family_name'], $testAttributes['family_name']);
        self::assertEquals($attributes['email'], $testAttributes['email']);
    }

    public function getModel()
    {
        return Person::class;
    }

    public function getEndpoint()
    {
        return '/api/countries/' . $this->country->id . '/president/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        return factory(Person::class)->$factoryMethod();
    }
}
