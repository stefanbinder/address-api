<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\Jobs\NotFoundRelationship;
use App\Exceptions\Api\NotImplementedException;
use App\Http\Resources\ApiResourceFactory;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;


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
     * @param ApiModel $model
     * @param string $related
     */
    public function __construct($request_data, ApiModel $model, $related)
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

        if (!method_exists($this->model, $related)) {
            throw new NotFoundRelationship($related, get_class($this->model));
        }

        $relation       = $this->model->$related();
        $eloquent       = $relation->getModel();
        $relationObject = $this->model->$related;

        /**
         * If the $relation is toMany, we always get a collection, which means first condition is accurate.
         * If the $relation is toOne, we either get the model of instance ApiModel OR null
         *      - so either return the resourceObject
         *      - or return null
         *
         * https://jsonapi.org/format/#fetching-relationships
         */

        if ($relationObject instanceof Collection) {

            $all   = request()->all();
            $items = ApiJobFactory::index($eloquent::ID, $all, $relation->getQuery());

            return ApiResourceFactory::resourceCollection($eloquent::ID, $items);
        } else if ($relationObject instanceof ApiModel) {
            return ApiResourceFactory::resourceObject($eloquent::ID, $relationObject);
        } else {

            // TODO: Put somewhere in a LinksHelper

            return [
                'data' => null,
            ];
        }

    }


}
