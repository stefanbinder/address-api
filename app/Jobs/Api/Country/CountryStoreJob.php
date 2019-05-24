<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Basic\StoreJob;
use App\Models\Address\Country;

class CountryStoreJob extends StoreJob
{
    protected function init()
    {
        $this->setApiModel( new Country() );
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
