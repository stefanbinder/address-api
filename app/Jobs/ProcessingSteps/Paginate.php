<?php

namespace App\Jobs\ProcessingSteps;

use Illuminate\Database\Eloquent\Builder;

class Paginate
{

    /**
     * Paginate constructor.
     * @param Builder $query
     * @param $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    static public function paginate($query, $per_page)
    {
        return $query->paginate($per_page);
    }

}
