<?php

namespace Tests\Feature\Address\Country;

use App\Models\Address\City;
use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\ApiModel;
use App\Models\User;
use App\Models\User\Person;
use Tests\Feature\RelatedEndpointsHelper;

class CountryRelatedCapitalTest extends RelatedEndpointsHelper
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
        self::assertEquals($attributes['name'], $testAttributes['name']);
    }

    public function getModel()
    {
        return City::class;
    }

    public function getEndpoint()
    {
        return '/api/countries/' . $this->country->id . '/capital/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        return factory(City::class)->$factoryMethod();
    }

    public function getRelationships(ApiModel $model)
    {
        return [];
    }

}
