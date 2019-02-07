<?php

namespace App\Jobs\Api;

use App\Http\Resources\ResourceFactory;
use App\Http\Resources\State\StatesResource;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class RelatedIndexJob implements ShouldQueue
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

        if( ! method_exists($this->model, $related) ) {
            throw new \Exception('The model "'.get_class($this->model).'" does not have relation "'.$related);
        }

        $relation = $this->model->$related();
        $relationModel = $relation->getModel();

        $resource = ResourceFactory::resource($relationModel::ID, $this->model->$related);

        return $resource;
    }

}
