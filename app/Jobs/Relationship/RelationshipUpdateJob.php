<?php

namespace App\Jobs\Relationship;

use App\Exceptions\Api\Jobs\ArrayNotAssignableToRelation;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RelationshipUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $relationship;
    private   $resourceData;

    /**
     * Create a new job instance.
     *
     * @param ApiModel $model
     * @param string $relationship
     * @param $resourceData
     */
    public function __construct(ApiModel $model, $relationship, $resourceData)
    {
        $this->model        = $model;
        $this->relationship = $relationship;
        $this->resourceData = $resourceData;
    }

    /**
     * Execute the job.
     *
     * @return array
     * @throws \Exception
     */
    public function handle()
    {
        return $this->process();
    }

    /**
     * Takes the data-object and extract the Identifier Object (or list) and syncs the list for the relationship
     *
     * @throws \Exception
     */
    public function process()
    {
        $model        = $this->model;
        $relationship = $this->relationship;
        $data         = $this->resourceData['data'];

        $relation = $model->$relationship();
        $eloquent = $relation->getModel();

        $response = ['data' => []];


        if ( is_identifier_object($data)) {
            $relationshipModel = ProcessRelations::saveOrAssociateEloquentWithIOToRelationship($relation, $eloquent, $data);
            $response['data'] = $relationshipModel->get_identifier_object();
        } else {

            $currentData  = $relation->getResults();
            $newIdsList       = Arr::pluck($data, 'id');

            if( ! $currentData instanceof Collection ) {
                // Array given by requester, relation is NOT a list => can't assign a proper value
                throw new ArrayNotAssignableToRelation();
            }

            $response['data'] = [];

            // 1. Deleting the items what are not given in the data-array as Identifier Object
            foreach ($currentData as $item) {
                if (!in_array($item->id, $newIdsList)) {
                    // An existing object is not inside the given list, we have to remove it.
                    ProcessRelations::deleteOrDissociateModelToRelationship($relation, $item);
                }
            }

            // 2. Adding the new Identifier Objects
            foreach ($data as $dataItem) {
                if(is_identifier_object($dataItem)) {
                    $relationshipModel = ProcessRelations::saveOrAssociateEloquentWithIOToRelationship($relation, $eloquent, $dataItem);
                    array_push($response['data'], $relationshipModel->get_identifier_object());
                }
            }

        }

        $model->push();

        return $response;
    }


}
