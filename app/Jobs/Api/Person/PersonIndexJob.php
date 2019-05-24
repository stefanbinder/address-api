<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Basic\DefaultIndexJob;
use App\Models\User\Person;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PersonIndexJob extends DefaultIndexJob
{

    protected function init()
    {
        parent::init();
        $this->setApiModel( new Person() );
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
