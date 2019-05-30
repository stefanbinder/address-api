<?php

namespace Tests\Feature\Address;

use App\Models\Address\Country;
use App\Models\Address\Vendor;
use Tests\Feature\DefaultEndpointsHelper;

class VendorTest extends DefaultEndpointsHelper
{
    public function assertAttributes($attributes, $testAttributes)
    {
        self::assertEquals($attributes['name'], $testAttributes['name']);
    }

    public function getModel()
    {
        return Vendor::class;
    }

    public function getEndpoint()
    {
        return '/api/vendors/';
    }
}
