<?php

namespace Tests;

use Faker\Generator as Faker;

class ApiTestCase extends TestCase
{

    protected $faker;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = new Faker();
    }

    public function createIdObject($type, $id = null, $attributes = null, $relationships = null)
    {
        $object = [
            'data' => [
                'type'          => $type,
                'attributes'    => [],
                'relationships' => [],
            ]
        ];

        if ($id) {
            $object['data']['id'] = $id;
        }

        if ($attributes) {
            $object['data']['attributes'] = $attributes;
        }

        if ($relationships) {
            $object['data']['relationships'] = $relationships;
        }

        return $object;
    }

    public function getAndAssertStatus($url, $headers = [], $status = 200)
    {
        $response = $this->get($url, $headers);
        return $this->assertResponseStatus($response, $status);
    }

    public function postAndAssertStatus($url, $data, $headers = [], $status = 200)
    {
        $response = $this->post($url, $data, $headers);
        return $this->assertResponseStatus($response, $status);
    }

    public function putAndAssertStatus($url, $data, $headers = [], $status = 200)
    {
        $this->assertArrayHasKey('data', $data);
        $idObject = $data['data'];
        $this->assertArrayHasKey('id', $idObject);
        $url = $url . $idObject['id'];

        $response = $this->put($url, $data, $headers);
        return $this->assertResponseStatus($response, $status);
    }

    public function deleteAndAssertStatus($url, $data, $headers = [], $status = 200)
    {
        $this->assertArrayHasKey('data', $data);
        $idObject = $data['data'];
        $this->assertArrayHasKey('id', $idObject);
        $url = $url . $idObject['id'];

        $response = $this->delete($url, $idObject, $headers);
        return $this->assertResponseStatus($response, $status, ['meta']);
    }

    public function assertResponseStatus($response, $status, $availableDataKeys = ['data', 'links', 'meta'])
    {
        if ($response->getStatusCode() !== $status) {
            print_r($response->json());
        }

        $response->assertStatus($status);
        $responseContent = $response->json();

        if ($status === 200) {
            forEach ($availableDataKeys as $dataKey) {
                $this->assertArrayHasKey($dataKey, $responseContent);
            }
        } else if ($status >= 400) {
            $this->assertArrayHasKey('errors', $responseContent);
        }

        return $responseContent;
    }

}
