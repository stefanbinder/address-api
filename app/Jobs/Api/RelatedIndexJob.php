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
        $relationModel  = $relation->getModel();
        $relationObject = $this->model->$related;

        if ($relationObject instanceof ApiModel) {
            return ApiResourceFactory::resourceObject($relationModel::ID, $relationObject);
        } else if ($relationObject instanceof Collection) {

            $filter_key = null;

            if ($relation instanceof HasOneOrMany) {
                $filter_key = $relation->getForeignKeyName();
            } else {
                throw new NotImplementedException('Missing Implementation of relationship handling! RelatedIndexjob@process');
            }

            // TODO: many to many will be interesting
//            $relation->getParentKey()                 => 1
//            $relation->getForeignKeyName()            => country_id
//            $relation->getExistenceCompareKey()       => states.country_id
//            $relation->getQualifiedParentKeyName()    => countries.id
//            $relation->getQualifiedForeignKeyName()   => states.country_id

            $all   = request()->all();
            $items = ApiJobFactory::index($relationModel::ID, array_merge($all, [
                'filter' => [
                    $filter_key => $this->model->id,
                ]
            ]));

            return ApiResourceFactory::resourceCollection($relationModel::ID, $items);
        }

    }


}
