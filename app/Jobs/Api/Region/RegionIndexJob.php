<?php

namespace App\Jobs\Api\Region;

use App\Jobs\Basic\DefaultIndexJob;
use App\Models\Address\Country;
use App\Models\Address\Region;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RegionIndexJob extends DefaultIndexJob
{

    protected function init()
    {
        parent::init();
        $this->setApiModel( new Region() );
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
