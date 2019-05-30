<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\Address\Vendor;
use App\Models\Tag;
use Tests\Feature\RelatedEndpointsHelper;

class CountryRelatedTagTest extends RelatedEndpointsHelper
{

    /**
     * @var Country
     */
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
        return Tag::class;
    }

    public function getEndpoint()
    {
        return '/api/countries/' . $this->country->id . '/tags/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        $vendor = factory(Tag::class)->$factoryMethod();
        $this->country->tags()->attach($vendor->id);
        return $vendor;
    }
}
