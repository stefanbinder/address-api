<?php

namespace App\Jobs\Api\MediaObject;

use App\Jobs\Basic\DefaultIndexJob;
use App\Models\MediaObject\MediaObject;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MediaObjectIndexJob extends DefaultIndexJob
{

    protected function init()
    {
        parent::init();
        $this->setApiModel( new MediaObject() );
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
