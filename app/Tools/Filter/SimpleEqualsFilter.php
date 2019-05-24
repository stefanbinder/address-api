<?php

namespace App\Tools\Filter;

use App\Contracts\Filter\IFilter;
use Illuminate\Database\Eloquent\Builder;

class SimpleEqualsFilter implements IFilter
{

    /**
     * Filter constructor.
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function filter($query, $filters)
    {

        foreach ($filters as $attribute => $filter) {
            $query->where($attribute, "=", $filter);
        }

        return $query;

    }

}
