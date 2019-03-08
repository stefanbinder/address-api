<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\Jobs\NotFoundRelatedException;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $related      = $this->related;
        $relatedModel = $this->model->$related()->withTrashed()->find($this->id);

        if (!$relatedModel) {
            throw new NotFoundRelatedException($related, $this->id, $this->model::ID, $this->model->id);
        }

        $destroyJob = ApiJobFactory::destroy($related);
        return $destroyJob::dispatchNow($relatedModel);
    }

}
