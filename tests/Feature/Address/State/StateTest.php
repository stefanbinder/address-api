<?php

namespace Tests\Feature\Address\State;

use App\Models\Address\State;
use App\Models\ApiModel;
use Tests\Feature\DefaultEndpointsHelper;

class StateTest extends DefaultEndpointsHelper
{
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
        return '/api/states/';
    }

    public function getRelationships(ApiModel $state)
    {
        return [
            'country' => [
                'data' => [
                    'type' => 'countries',
                    'id' => $state->country->id
                ]
            ]
        ];
    }
}
