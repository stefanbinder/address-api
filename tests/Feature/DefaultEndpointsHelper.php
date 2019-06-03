<?php

namespace Tests\Feature;

use App\Models\Address\Country;
use App\Models\ApiModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ApiTestCase;

abstract class DefaultEndpointsHelper extends ApiTestCase
{

    use RefreshDatabase;

    abstract public function assertAttributes($attributes, $testAttributes);
    abstract public function getModel();
    abstract public function getEndpoint();
    abstract public function getRelationships(ApiModel $model);

    public function testIndex()
    {
        $model = factory($this->getModel())->create();
        $response = $this->getAndAssertStatus($this->getEndpoint());

        foreach($response['data'] as $listItem) {
            if($listItem['id'] === $model->id) {
                $this->assertModelWithModelIdentifierObj($model, $listItem);
            }
        }
    }

    public function testShow()
    {
        $model = factory($this->getModel())->create();
        $response = $this->getAndAssertStatus($this->getEndpoint() . $model->id);
        $this->assertModelWithModelIdentifierObj($model, $response['data']);
    }

    public function testStore()
    {
        $model = factory($this->getModel())->make();
        $modelData = $this->createIdObject($model::ID, null, $model->getAttributes(), $this->getRelationships($model));

        $response = $this->postAndAssertStatus($this->getEndpoint(), $modelData, [], 201);
        $this->assertModelIdentifierWithModelIdentifier($modelData['data'], $response['data']);
    }

    public function testUpdate()
    {
        $model = factory($this->getModel())->create();
        $modelFaker = factory($this->getModel())->make();

        $modelData = $this->createIdObject($model::ID, $model->id, $modelFaker->getAttributes(), $this->getRelationships($model));
        $response = $this->putAndAssertStatus($this->getEndpoint(), $modelData, [], 200);
        $this->assertModelIdentifierWithModelIdentifier($modelData['data'], $response['data']);
    }

    public function testDelete()
    {
        $model = factory($this->getModel())->create();

        $modelData = $this->createIdObject($model::ID, $model->id);
        $response = $this->deleteAndAssertStatus($this->getEndpoint(), $modelData, [], 200);

        $this->assertEquals('deleted', $response['meta']['message']);
        $this->assertEquals($model->id, $response['meta']['id']);

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
