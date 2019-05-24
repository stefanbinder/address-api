<?php

namespace App\Contracts\Filter;

interface IFilter
{

    /**
     * Takes a Eloquent Query Builder, applies filter and returns the Eloquent Query Builder
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter($query, $filters);

}
