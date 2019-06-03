<?php

namespace App\Jobs\Api\City;

use App\Jobs\Basic\StoreJob;
use App\Models\Address\City;
use App\Models\Address\Country;

class CityStoreJob extends StoreJob
{
    protected function init()
    {
        $this->setApiModel( new City() );
    }

//    protected function processAttributesBeforeCreate(array $attributes)
//    {
//        return $attributes;
//    }

//    protected function processModelAfterCreate( ApiModel $country )
//    {
//        return $country;
//    }

}
