<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\Address\Vendor;
use Tests\Feature\RelatedEndpointsHelper;

class CountryRelatedVendorTest extends RelatedEndpointsHelper
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
        return Vendor::class;
    }

    public function getEndpoint()
    {
        return '/api/countries/' . $this->country->id . '/vendors/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        $vendor = factory(Vendor::class)->$factoryMethod();
        $this->country->vendors()->attach($vendor->id);
        return $vendor;
    }
}
