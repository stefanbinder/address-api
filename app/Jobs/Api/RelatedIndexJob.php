<?php

namespace App\Jobs\Api;

use App\Http\Resources\ResourceFactory;
use App\Jobs\Api\State\StateIndexJob;
use App\Jobs\ProcessingSteps\RetrieveRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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

        if( ! method_exists($this->model, $related) ) {
            throw new \Exception('The model "'.get_class($this->model).'" does not have relation "'.$related);
        }

        $relation = $this->model->$related();
        $relationModel = $relation->getModel();
        $relationObject = $this->model->$related;

        if($relationObject instanceof ApiModel) {
            return ResourceFactory::resourceObject($relationModel::ID, $relationObject);
        } else if( $relationObject instanceof Collection) {

            $filter_key = null;

            if($relation instanceof HasOneOrMany) {
                $filter_key = $relation->getForeignKeyName();
            } else {
                throw new \Exception('Implement!!! RelatedIndexjob@process');
            }

            // TODO: many to many will be interesting
//            $relation->getParentKey()                 => 1
//            $relation->getForeignKeyName()            => country_id
//            $relation->getExistenceCompareKey()       => states.country_id
//            $relation->getQualifiedParentKeyName()    => countries.id
//            $relation->getQualifiedForeignKeyName()   => states.country_id

            $all = request()->all();
            $items = ApiJobFactory::index($relationModel::ID, array_merge($all, [
                'filter' => [
                    $filter_key => $this->model->id,
                ]
            ]));
            return ResourceFactory::resourceCollection($relationModel::ID, $items);
        }

    }


}
