<?php

namespace App\Jobs\Api\City;

use App\Jobs\Basic\DefaultIndexJob;
use App\Models\Address\City;

class CityIndexJob extends DefaultIndexJob
{

    protected function init()
    {
        parent::init();
        $this->setApiModel( new City() );
    }

//    protected function processBuilder(Builder $builder)
//    {
//        return $builder;
//    }
//
//    protected function processList(Collection $collection)
//    {
//        return $collection;
//    }
//
//    protected function processPagination(Paginator $paginator)
//    {
//        return $paginator;
//    }

}
