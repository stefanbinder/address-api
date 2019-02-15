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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class RelatedStoreJob implements ShouldQueue
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

    /**
     * Create a new job instance.
     *
     * @param $request_data
     * @param Model $model
     * @param string $related
     * @param $id
     */
    public function __construct($request_data, Model $model, $related)
    {
        $this->request_data = $request_data;
        $this->model        = $model;
        $this->related      = $related;
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

        // Get the request for the related object, for retrieving the Rules/Validator
        // TODO: Refactor to validator
        $request   = ApiRequestFactory::store($related);
        $validator = Validator::make($this->request_data, (new $request)->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validatedData = $validator->validate();

        if (!method_exists($this->model, $related)) {
            throw new \Exception('The given relation "' . $related . '" does not exist on model');
        }

        // Validation done, Relation exists: Now we can store related object and attach to model
        $storeJob = ApiJobFactory::store($related);
        $relatedModel = $storeJob::dispatchNow($validatedData);

        $this->model->$related()->save($relatedModel);

        return $relatedModel;
    }

}