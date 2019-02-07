<?php

namespace App\Jobs\Api;

use App\Jobs\ProcessingSteps\EagerLoading;
use App\Jobs\ProcessingSteps\Filter;
use App\Jobs\ProcessingSteps\Ordering;
use App\Jobs\ProcessingSteps\Paginate;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
     * Create a new job instance
     * @param $request_data
     */
    public function __construct($request_data)
    {
        $this->model        = $this->getEloquent();
        $this->request_data = $request_data;
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

    /**
     * Returns the paginated list after filtering and ordering
     *
     */
    public function process()
    {
        // Query-Builder Part
        $query = $this->model::query();

        $query = EagerLoading::loading($query, $this->model::ID);
        $query = Ordering::order($query, data_get($this->request_data, 'sort', self::DEFAULT_SORT_STRING));

        $filterable = $this->model::FILTERABLE ?? [];
        $query      = Filter::filter($query, $filterable, data_get($this->request_data, 'filter', []));

        // Transform query to LengthAwarePagination
        $pagination = Paginate::paginate($query, data_get($this->request_data, 'per_page', self::DEFAULT_PER_PAGE));

        return $pagination;
    }


}
