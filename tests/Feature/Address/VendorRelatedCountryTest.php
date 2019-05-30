<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\Address\Vendor;
use App\Models\Tag;
use Tests\Feature\RelatedEndpointsHelper;

class VendorRelatedCountryTest extends RelatedEndpointsHelper
{

    /**
     * @var Vendor
     */
    protected $vendor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vendor = factory(Vendor::class)->create();
    }

    public function assertAttributes($attributes, $testAttributes)
    {
        self::assertEquals($attributes['name'], $testAttributes['name']);
    }

    public function getModel()
    {
        return Country::class;
    }

    public function getEndpoint()
    {
        return '/api/vendors/' . $this->vendor->id . '/countries/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        $country = factory(Country::class)->$factoryMethod();
        $this->vendor->countries()->attach($country->id);
        return $country;
    }
}
