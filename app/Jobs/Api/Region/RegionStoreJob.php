<?php

namespace App\Jobs\Api\Region;

use App\Jobs\Basic\StoreJob;
use App\Models\Address\Country;
use App\Models\Address\Region;

class RegionStoreJob extends StoreJob
{
    protected function init()
    {
        $this->setApiModel( new Region() );
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
