<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Basic\DefaultIndexJob;
use App\Models\Address\Country;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CountryIndexJob extends DefaultIndexJob
{

    protected function init()
    {
        parent::init();
        $this->setApiModel( new Country() );
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
