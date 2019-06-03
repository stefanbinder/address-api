<?php

namespace Tests\Feature\Address\Country;

use App\Models\Address\Country;
use App\Models\ApiModel;
use Tests\Feature\DefaultEndpointsHelper;

class CountryTest extends DefaultEndpointsHelper
{
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
        return '/api/countries/';
    }

    public function getRelationships(ApiModel $model)
    {
        return [
            'region' => [
                'data' => [
                    'type' => 'regions',
                    'id' => $model->region->id
                ]
            ]
        ];
    }
}
