<?php

namespace Tests\Feature;

use App\Models\Address\Country;
use App\Models\ApiModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ApiTestCase;

abstract class RelatedEndpointsHelper extends ApiTestCase
{

    use RefreshDatabase;

    abstract public function assertAttributes($attributes, $testAttributes);
    abstract public function getModel();
    abstract public function getFactory($factoryMethod='create');
    abstract public function getEndpoint();
    abstract public function getRelationships(ApiModel $model);

    public function testIntegration()
    {

        /**
         *  1. STORE / CREATE
         */

        $model = $this->getFactory('make');

        $modelData = $this->createIdObject($model::ID, null, $model->getAttributes(), $this->getRelationships($model));

        $response = $this->postAndAssertStatus($this->getEndpoint(), $modelData, [], 201);
        $this->assertModelIdentifierWithModelIdentifier($modelData['data'], $response['data']);

        $relatedModelId = $response['data'];

        /**
         * 2. INDEX
         * depending on type, single item or list,
         * eg. countries/1/states => list
         *     countries/1/president => item
         */

        $response = $this->getAndAssertStatus($this->getEndpoint());

        if( is_identifier_object($response) ) {
            $this->assertModelIdentifierWithModelIdentifier($relatedModelId, $response['data']);
        } else {

            foreach($response['data'] as $listItem) {
                if($listItem['id'] === $relatedModelId['id']) {
                    $this->assertModelIdentifierWithModelIdentifier($relatedModelId, $listItem);
                }
            }

        }

        /**
         * 3. SHOW
         */

        $response = $this->getAndAssertStatus($this->getEndpoint() . $relatedModelId['id']);
        $this->assertModelIdentifierWithModelIdentifier($relatedModelId, $response['data']);

        /**
         * 4. UPDATE
         */

        $modelFaker = factory($this->getModel())->make();

        $modelData = $this->createIdObject($model::ID, $relatedModelId['id'], $modelFaker->getAttributes(), $this->getRelationships($model));
        $response = $this->putAndAssertStatus($this->getEndpoint(), $modelData, [], 200);
        $this->assertModelIdentifierWithModelIdentifier($modelData['data'], $response['data']);

        $relatedModelId = $response['data'];

        /**
         * 5. DELETE
         */

        $modelData = $this->createIdObject($model::ID, $relatedModelId['id']);
        $response = $this->deleteAndAssertStatus($this->getEndpoint(), $modelData, [], 200);

        $this->assertEquals('deleted', $response['meta']['message']);
        $this->assertEquals($relatedModelId['id'], $response['meta']['id']);

        $response = $this->deleteAndAssertStatus($this->getEndpoint(), $modelData, [], 200);

        $this->assertStringStartsWith('It was already deleted on', $response['meta']['message']);

    }

    public function assertModelWithModelIdentifierObj($model, $testCountryId)
    {
        $this->assertEquals($model::ID, $testCountryId['type']);

        $this->assertArrayHasKey('attributes', $testCountryId);
        $attributes = $testCountryId['attributes'];

        $this->assertAttributes($model->getAttributes(), $attributes);
    }

    public function assertModelIdentifierWithModelIdentifier($modelId, $testCountryId)
    {
        $this->assertEquals($modelId['type'], $testCountryId['type']);

        $this->assertArrayHasKey('attributes', $testCountryId);
        $attributes = $modelId['attributes'];
        $testAttributes = $testCountryId['attributes'];

        $this->assertAttributes($attributes, $testAttributes);
    }

}
