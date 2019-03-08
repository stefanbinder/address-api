<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\Jobs\NotFoundRelatedException;
use App\Exceptions\Api\Jobs\NotFoundRelationship;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class RelatedShowJob implements ShouldQueue
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
    protected $id;

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

        if (!method_exists($this->model, $related)) {
            throw new NotFoundRelationship($related, get_class($this->model));
        }

        return $this->getModelFromRelation($this->model->$related(), $this->id);
    }

    /**
     * @param Relation $relation
     * @param $id
     * @return \App\Models\ApiModel|\Illuminate\Database\Eloquent\Model|null
     * @throws NotFoundRelatedException
     */
    private function getModelFromRelation(Relation $relation, $id)
    {
        $model = $relation->find($id);

        if (!$model) {
            throw new NotFoundRelatedException($this->related, $id, $this->model::ID, $this->model->id);
        }

        return $model;
    }

}
