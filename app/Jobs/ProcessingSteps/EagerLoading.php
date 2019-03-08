<?php

namespace App\Jobs\ProcessingSteps;

use Illuminate\Database\Eloquent\Builder;

class EagerLoading
{

    /**
     * EagerLoading includes already in the beginning
     *
     * @param Builder $query
     * @param $modelId
     * @return Builder
     */
    static public function loading($query, $modelId)
    {
        $includes = request()->input('include');

        if ($includes && $includes !== '' && array_key_exists($modelId, $includes)) {
            $query->with(explode(",", $includes[$modelId]));
        }

        return $query;
    }

}
