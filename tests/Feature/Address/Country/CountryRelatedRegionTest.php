<?php

namespace Tests\Feature\Address\Country;

use App\Models\Address\Country;
use App\Models\Address\Region;
use App\Models\Address\State;
use App\Models\Address\Vendor;
use App\Models\ApiModel;
use Tests\Feature\RelatedEndpointsHelper;

class CountryRelatedRegionTest extends RelatedEndpointsHelper
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
        return Region::class;
    }

    public function getEndpoint()
    {
        return '/api/countries/' . $this->country->id . '/region/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        return factory(Region::class)->$factoryMethod();
    }

    public function getRelationships(ApiModel $model)
    {
        return [];
    }
}
