<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\Jobs\NotFoundRelationship;
use App\Exceptions\Api\Jobs\ValidationException;
use App\Http\Requests\Api\ApiRequestFactory;
use App\Jobs\ProcessingSteps\ProcessRelations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;

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

        if( ! method_exists( $this->model, $related ) ) {
            throw new NotFoundRelationship($related, get_class($this->model));
        }

        $relatedModel = ProcessRelations::getAndStoreOrUpdateRelationModel($this->model->$related(), $this->request_data);
        return $relatedModel;
    }

}
