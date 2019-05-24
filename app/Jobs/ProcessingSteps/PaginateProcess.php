<?php

namespace App\Jobs\ProcessingSteps;

use App\Contracts\Pagination\IPaginator;
use App\Models\ApiModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class PaginateProcess
{

    const DEFAULT_PER_PAGE = 25;

    private $paginator;

    public function __construct( IPaginator $paginator=null )
    {
        $this->setPaginator($paginator);
    }

    /**
     * Takes parameters inside the $args array and process something
     *
     * @param Builder $builder
     * @param ApiModel $model
     * @param array $request_data
     * @return Paginator $paginator
     */
    public function process(Builder $builder, ApiModel $model, array $request_data)
    {
        $per_page = data_get($request_data, 'per_page', self::DEFAULT_PER_PAGE);
        return $this->paginator->paginate($builder, $per_page, null);
    }

    public function setPaginator( IPaginator $paginator )
    {
        $this->paginator = $paginator;
    }

}
