<?php

namespace App\Jobs\Related;

use App\Exceptions\Api\Jobs\NotFoundRelatedException;
use App\Jobs\Api\ApiJobFactory;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RelatedDestroyJob implements ShouldQueue
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
     * @throws \Exception
     */
    public function handle()
    {
        $related      = $this->related;
        $relatedModel = $this->model->$related()->withTrashed()->find($this->id);

        if (!$relatedModel) {
            throw new NotFoundRelatedException($related, $this->id, $this->model::ID, $this->model->id);
        }

        $destroyJob = ApiJobFactory::destroy($relatedModel::ID);
        return $destroyJob::dispatchNow($relatedModel);
    }

}
