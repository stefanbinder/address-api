<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Basic\StoreJob;
use App\Models\Tag;

class TagStoreJob extends StoreJob
{
    protected function init()
    {
        $this->setApiModel( new Tag() );
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
