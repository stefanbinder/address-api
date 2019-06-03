<?php

namespace Tests\Feature\Address\Region;

use App\Models\Address\Region;
use App\Models\ApiModel;
use Tests\Feature\DefaultEndpointsHelper;

class RegionTest extends DefaultEndpointsHelper
{
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
        return '/api/regions/';
    }

    public function getRelationships(ApiModel $model)
    {
        return [];
    }
}
