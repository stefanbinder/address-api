<?php

namespace App\Jobs\ProcessingSteps;

use App\Contracts\Process\IQueryProcess;
use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Builder;

class EagerLoadingProcess implements IQueryProcess
{

    /**
     * Take the query-builder and manipulate it.
     *
     * @param Builder $builder
     * @param ApiModel $model
     * @param array $request_data
     * @return Builder $builder
     */
    public function process(Builder $builder, ApiModel $model, array $request_data)
    {
        $includes = request()->input('include');

        if ($includes && $includes !== '' && array_key_exists($model::ID, $includes)) {
            $builder->with(explode(",", $includes[$model::ID]));
        }

        return $builder;
    }
}
