<?php

namespace Tests\Feature\Address\City;

use App\Models\Address\City;
use App\Models\ApiModel;
use Tests\Feature\DefaultEndpointsHelper;

class CityTest extends DefaultEndpointsHelper
{
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
        return '/api/cities/';
    }

    public function getRelationships(ApiModel $model)
    {
        return [];
    }
}
