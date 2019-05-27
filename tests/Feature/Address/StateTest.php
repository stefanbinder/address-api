<?php

namespace Tests\Feature\Address;

use App\Models\Address\State;
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
}
