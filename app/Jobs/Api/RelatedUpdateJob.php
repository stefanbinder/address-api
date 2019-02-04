<?php

namespace App\Jobs\Api;

use App\Http\Requests\Api\ApiRequestFactory;
use App\Http\Requests\Api\State\StateStoreRequest;
use App\Http\Resources\State\StateResource;
use App\Jobs\Api\State\StateStoreJob;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\App;

abstract class RelatedUpdateJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $related;
    protected $request_data;
    private   $id;

    /**
     * Create a new job instance.
     *
     * @param $request_data
     * @param Model $model
     * @param string $related
     * @param $id
     */
    public function __construct($request_data, Model $model, $related, $id)
    {
        $this->request_data = $request_data;
        $this->model        = $model;
        $this->related      = $related;
        $this->id           = $id;
    }

    /**
     * Execute the job.
     *
     * @return array
     * @throws \Exception
     */
    abstract public function handle();

    /**
     * @throws \Exception
     */
    public function process()
    {
        $related = $this->related;

        $stateRequest = ApiRequestFactory::store($related);
        $storeDate    = $stateRequest->validated();

        $storeJob     = ApiJobFactory::store($related);
        $relatedModel = $storeJob::dispatchNow($storeDate);

        if (!method_exists($this->model, $related)) {
            throw new \Exception('The given relation "' . $related . '" does not exist on model');
        }

        $this->model->$related()->save($relatedModel);

        return $relatedModel;
    }

}
