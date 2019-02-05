<?php

namespace App\Jobs\Api;

use App\Http\Requests\Api\ApiRequestFactory;
use App\Http\Requests\Api\State\StateStoreRequest;
use App\Http\Resources\State\StateResource;
use App\Jobs\Api\State\StateStoreJob;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
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

abstract class RelatedDestroyJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ApiModel
     */
    protected $model;

    /**
     * @var string
     */
    protected $related;
    private   $id;

    /**
     * Create a new job instance.
     *
     * @param ApiModel $model
     * @param string $related
     * @param $id
     */
    public function __construct(ApiModel $model, $related, $id)
    {
        $this->model   = $model;
        $this->related = $related;
        $this->id      = $id;
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

        $relationship = $this->model->$related();
        $relatedModel = ProcessRelations::getRelationModel($relationship, $related, $this->id);
        $destroyJob   = ApiJobFactory::destroy($related);

        return $destroyJob::dispatchNow($relatedModel);
    }

}
