<?php

namespace App\Jobs\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
            throw new \Exception('The given relation "' . $related . '" does not exist on model');
        }

        return $this->getModelFromRelation($this->model->$related(), $this->id);
    }

    /**
     * @param Relation $relation
     * @param $id
     * @return \App\Models\ApiModel|\Illuminate\Database\Eloquent\Model|null
     */
    private function getModelFromRelation(Relation $relation, $id)
    {
        $relationModel = $relation->getModel();
        $model = $relationModel::find($id);
        return $model;
    }

}
