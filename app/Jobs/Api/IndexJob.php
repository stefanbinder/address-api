<?php

namespace App\Jobs\Api;

use App\Jobs\ProcessingSteps\EagerLoading;
use App\Jobs\ProcessingSteps\Filter;
use App\Jobs\ProcessingSteps\Ordering;
use App\Jobs\ProcessingSteps\Paginate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class IndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const DEFAULT_PER_PAGE    = 20;
    const DEFAULT_SORT_STRING = 'id';

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $processing_steps = [];
    protected $request_data;
    /**
     * @var null
     */
    private $query;

    /**
     * Created a new IndexJob for retrieving a list of resources
     *
     * @param $request_data
     * @param Builder $query (can be from a relation eg. $model->relationship()->getQuery() for having a prepared query
     */
    public function __construct($request_data, Builder $query = null)
    {
        $this->model        = $this->getEloquent();
        $this->request_data = $request_data;
        $this->query        = $query;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Returns the eloquent-model which is used in the IndexJob
     * @return Model
     */
    abstract protected function getEloquent();

    public function setQuery( Builder $query ) {
        $this->query = $query;
    }

    /**
     * Returns the paginated list after filtering and ordering
     *
     */
    public function process()
    {
        // Query-Builder Part
        $query = $this->query ?? $this->model::query();

        $query = EagerLoading::loading($query, $this->model::ID);
        $query = Ordering::order($query, data_get($this->request_data, 'sort', self::DEFAULT_SORT_STRING));

        $filterable = $this->model::FILTERABLE ?? [];
        $query      = Filter::filter($query, $filterable, data_get($this->request_data, 'filter', []));

        // Transform query to LengthAwarePagination
        $pagination = Paginate::paginate($query, data_get($this->request_data, 'per_page', self::DEFAULT_PER_PAGE));

        return $pagination;
    }


}
