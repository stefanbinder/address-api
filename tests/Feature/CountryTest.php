<?php

namespace Tests\Feature;

use App\Country;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCountryIndex()
    {
        $country = factory(Country::class)->create();

        $response = $this->get('/api/countries');

        $response->assertStatus(200);
        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('data', $responseContent);
        $this->assertArrayHasKey('links', $responseContent);
        $this->assertArrayHasKey('meta', $responseContent);

        foreach($responseContent['data'] as $listItem) {
            if($listItem['id'] === $country->id) {

                $this->assertEquals($country->id, $listItem['id']);
                $this->assertEquals('countries', $listItem['type']);

                $this->assertArrayHasKey('attributes', $listItem);
                $attributes = $listItem['attributes'];

                $this->assertEquals($country->name, $attributes['name']);
                $this->assertEquals($country->code2, $attributes['code2']);
                $this->assertEquals($country->code3, $attributes['code3']);

                $this->assertCount(2, strlen($attributes['code2']));
                $this->assertCount(3, strlen($attributes['code3']));
            }
        }
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCountryShow()
    {
        $country = factory(Country::class)->create();

        $response = $this->get('/api/countries/' . $country->id);

        $response->assertStatus(200);
        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('data', $responseContent);
        $this->assertArrayHasKey('links', $responseContent);
        $this->assertArrayHasKey('meta', $responseContent);

        foreach($responseContent['data'] as $listItem) {
            if($listItem['id'] === $country->id) {

                $this->assertEquals($country->id, $listItem['id']);
                $this->assertEquals('countries', $listItem['type']);

                $this->assertArrayHasKey('attributes', $listItem);
                $attributes = $listItem['attributes'];

                $this->assertEquals($country->name, $attributes['name']);
                $this->assertEquals($country->code2, $attributes['code2']);
                $this->assertEquals($country->code3, $attributes['code3']);

                $this->assertCount(2, strlen($attributes['code2']));
                $this->assertCount(3, strlen($attributes['code3']));
            }
        }
    }

}
