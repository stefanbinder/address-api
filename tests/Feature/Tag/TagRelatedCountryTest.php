<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Tag;
use Tests\Feature\RelatedEndpointsHelper;

class TagRelatedCountryTest extends RelatedEndpointsHelper
{

    /**
     * @var Tag
     */
    protected $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tag = factory(Tag::class)->create();
    }

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
        return '/api/tags/' . $this->tag->id . '/countries/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        $country = factory(Country::class)->$factoryMethod();
        $this->tag->countries()->attach($country->id);
        return $country;
    }
}
