<?php

namespace App\Jobs\Api;

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

abstract class StoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
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
     *
     * @return Model
     */
    abstract protected function getEloquent();

    public function process()
    {
        $resourceObject = $this->request_data['data'];

        if( $this->model::ID !== $resourceObject['type'] ) {
            // TODO: Exception Handling
            throw new \Exception('ModelID does not fit the given type, cannot create resource');
        }

        $attributes = $this->processAttributes($resourceObject['attributes']);

        $model = $this->model::create($attributes);

        return $model;

    }

    /**
     * Can always be overwritten for own purpose
     *
     * @param array $attributes
     * @return array
     */
    public function processAttributes($attributes)
    {
        return $attributes;
    }


}
