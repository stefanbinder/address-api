<?php

namespace App\Jobs\ProcessingSteps;

use Illuminate\Database\Eloquent\Builder;

class Ordering
{

    /**
     * Ordering constructor.
     * @param Builder $query
     * @param $sort
     * @return Builder
     */
    static public function order(Builder $query, $sort)
    {
        $sortDirection = 'asc';

        if (substr($sort, 0, 1) === '-') {
            $sortDirection = 'desc';
            $sort          = substr($sort, 1, strlen($sort));
        }

        // Just sort if it is specified that it is sortable
        $query->orderBy($sort, $sortDirection);

        return $query;
    }

}
