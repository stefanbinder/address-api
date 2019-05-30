<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Basic\StoreJob;
use App\Models\User\Person;

class PersonStoreJob extends StoreJob
{
    protected function init()
    {
        $this->setApiModel( new Person() );
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
