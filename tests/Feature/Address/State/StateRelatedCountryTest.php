<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\ApiModel;
use Tests\Feature\RelatedEndpointsHelper;

class StateRelatedCountryTest extends RelatedEndpointsHelper
{

    /**
     * @var State
     */
    protected $state;

    protected function setUp(): void
    {
        parent::setUp();
        $this->state = factory(State::class)->create();
    }

    public function assertAttributes($attributes, $testAttributes)
    {
        self::assertEquals($attributes['name'], $testAttributes['name']);
        self::assertEquals($attributes['code2'], $testAttributes['code2']);
        self::assertEquals($attributes['code3'], $testAttributes['code3']);
    }

    public function getModel()
    {
        return Country::class;
    }

    public function getEndpoint()
    {
        return '/api/states/' . $this->state->id . '/country/';
    }

    public function getFactory($factoryMethod = 'create')
    {
        $country = factory(Country::class)->$factoryMethod();
        $this->state->country_id = $country->id;
        $this->state->push();
        return $country;
    }

    public function getRelationships(ApiModel $country)
    {
        return [
            'region' => [
                'data' => [
                    'type' => 'countries',
                    'id' => $country->region->id
                ]
            ]
        ];
    }

}
