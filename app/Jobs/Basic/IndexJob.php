<?php

namespace App\Jobs\Basic;

use App\Contracts\Filter\IFilter;
use App\Contracts\Pagination\IPaginator;
use App\Contracts\Process\IQueryProcess;
use App\Jobs\ProcessingSteps\FilterProcess;
use App\Jobs\ProcessingSteps\OrderingProcess;
use App\Jobs\ProcessingSteps\PaginateProcess;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class IndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const DEFAULT_PER_PAGE = 20;

    protected $model;
    protected $request_data;
    protected $query;

    private   $paginateProcess;
    protected $queryProcesses = [];

    /**
     * Created a new IndexJob for retrieving a list of resources
     *
     * @param $request_data
     * @param Builder $query (can be from a relation eg. $model->relationship()->getQuery() for having a prepared query
     */
    public function __construct($request_data, Builder $query = null)
    {
        $this->request_data = $request_data;
        $this->query        = $query;

        $this->init();
    }

    /**
     * Initialize the IndexJob with the wished and needed attributes
     */
    abstract protected function init();

    /**
     * Execute the job.
     *
     * @return Paginator|array|Collection
     */
    public function handle()
    {
        // Query-Builder Part
        $query        = $this->query ?? $this->model::query();
        $model        = $this->model;
        $request_data = $this->request_data;

        forEach ($this->queryProcesses as $queryProcess) {
            $query = $queryProcess->process($query, $model, $request_data);
        }

        $query = $this->processBuilder($query);

        // Until here we work with the query, now we transform query-builder into a paginator OR array
        if ($this->paginateProcess) {
            $pagination = $this->paginateProcess->process($query, $model, $request_data);
            $pagination = $this->processPagination($pagination);
            return $pagination;
        } else {
            $list = $query->get();
            $list = $this->processList($list);
            return $list;
        }

    }

    /**
     * Set the filter, which will be applied to the query-builder
     *
     * @param IFilter $filter
     */
    public function setFilter(IFilter $filter)
    {
        $filterProcess = new FilterProcess($filter);
        $this->addQueryProcess($filterProcess);
    }

    /**
     * Set the default OrderingProcess
     */
    public function setOrdering()
    {
        $this->addQueryProcess(new OrderingProcess());
    }

    /**
     * Set the default OrderingProcess
     * @param IPaginator $paginator
     */
    public function setPagination(IPaginator $paginator)
    {
        $this->paginateProcess = new PaginateProcess($paginator);
    }

    /**
     * Set the ApiModel, of which the processing steps will be applied
     *
     * @param ApiModel $model
     */
    public function setApiModel(ApiModel $model)
    {
        $this->model = $model;
    }

    /**
     * Preset the query, if there is already a query-builder prepared
     *
     * @param Builder $query
     */
    public function setQuery(Builder $query)
    {
        $this->query = $query;
    }

    public function addQueryProcess(IQueryProcess $process)
    {
        array_push($this->queryProcesses, $process);
    }

    /**
     * Override function for manipulating the query
     *
     * @param Builder $builder
     * @return Builder $builder
     */
    protected function processBuilder(Builder $builder)
    {
        return $builder;
    }

    /**
     * Override function for manipulating the pagination object
     *
     * @param Paginator $pagination
     * @return Paginator $pagination
     */
    protected function processPagination(Paginator $pagination)
    {
        return $pagination;
    }

    /**
     * Override function for manipulating the array
     *
     * @param Collection $list
     * @return Collection $list
     */
    protected function processList(Collection $list)
    {
        return $list;
    }

}
