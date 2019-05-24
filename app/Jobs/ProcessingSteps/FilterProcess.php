<?php

namespace App\Jobs\ProcessingSteps;

use App\Contracts\Filter\IFilter;
use App\Contracts\Process\IQueryProcess;
use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Builder;

class FilterProcess implements IQueryProcess
{

    private $filter;

    public function __construct( IFilter $filter=null )
    {
        $this->setFilter($filter);
    }

    /**
     * Takes parameters inside the $args array and process something
     *
     * @param Builder $builder
     * @param ApiModel $model
     * @param array $request_data
     * @return Builder $builder
     */
    public function process(Builder $builder, ApiModel $model, array $request_data)
    {

        $filterable = $model::FILTERABLE ?? [];
        $filters = data_get($request_data, 'filter', []);
        $filters = array_only($filters, $filterable);

        $builder = $this->filter->filter($builder, $filters);

        return $builder;
    }

    public function setFilter( IFilter $filter )
    {
        $this->filter = $filter;
    }

}
