<?php

namespace App\Jobs\ProcessingSteps;

use App\Contracts\Process\IQueryProcess;
use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Builder;

class OrderingProcess implements IQueryProcess
{

    const DEFAULT_SORT_STRING = 'id';

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
        $sort =  data_get($request_data, 'sort', self::DEFAULT_SORT_STRING);
        $sortDirection = 'asc';

        if (substr($sort, 0, 1) === '-') {
            $sortDirection = 'desc';
            $sort          = substr($sort, 1, strlen($sort));
        }

        // Just sort if it is specified that it is sortable
        $builder->orderBy($sort, $sortDirection);

        return $builder;
    }
}
