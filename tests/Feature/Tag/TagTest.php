<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\ApiModel;
use App\Models\Tag;
use Tests\Feature\DefaultEndpointsHelper;

class TagTest extends DefaultEndpointsHelper
{
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
        return '/api/tags/';
    }

    public function getRelationships(ApiModel $model)
    {
        return [];
    }

}
