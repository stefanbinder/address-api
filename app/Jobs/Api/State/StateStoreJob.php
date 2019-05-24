<?php

namespace App\Jobs\Api\State;

use App\Jobs\Basic\StoreJob;
use App\Models\Address\State;

class StateStoreJob extends StoreJob
{
    protected function init()
    {
        $this->setApiModel( new State() );
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
