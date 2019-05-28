<?php

namespace App\Jobs\Related;

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

class RelatedStoreJob implements ShouldQueue
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
     * @param array $request_data
     * @param Model $model
     * @param string $related
     */
    public function __construct(array $request_data, Model $model, $related)
    {
        $this->request_data = $request_data;
        $this->model        = $model;
        $this->related      = $related;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $related = $this->related;

        if( ! method_exists( $this->model, $related ) ) {
            throw new NotFoundRelationship($related, get_class($this->model));
        }

        $relatedModel = ProcessRelations::processRelationship($this->model->$related(), $this->request_data);
        $this->model->push();

        return $relatedModel;
    }

}
