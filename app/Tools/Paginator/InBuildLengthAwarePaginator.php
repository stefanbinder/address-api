<?php

namespace App\Tools\Paginator;

use App\Contracts\Pagination\IPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class InBuildLengthAwarePaginator implements IPaginator
{

    /**
     * Takes a Eloquent Query Builder, applies pagination and returns the paginated resource
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $per_page
     * @param $current_page
     * @return Paginator
     */
    public function paginate(Builder $query, $per_page, $current_page)
    {
        return $query->paginate($per_page);
    }
}
