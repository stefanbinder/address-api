<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\ResourceObjectTypeError;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RelationshipStoreJob implements ShouldQueue
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
     * @throws \Exception
     */
    public function process()
    {
        $model        = $this->model;
        $relationship = $this->relationship;

        $id   = $this->resourceData['data']['id'];
        $type = $this->resourceData['data']['type'];

        $relationshipObject   = $model->$relationship();
        $relationshipEloquent = $relationshipObject->getModel();

        if ($relationshipEloquent::ID !== $type) {
            throw new ResourceObjectTypeError($type, $relationshipEloquent::ID);
        }

        $relationshipModel = $relationshipEloquent::find($id);

        if (!$relationshipModel) {
            throw new NotFoundException(get_class($relationshipEloquent), $id);
        }

        ProcessRelations::saveOrAssociateModelToRelationship($relationshipObject, $relationshipModel);
        $model->push();

        $relationships = [
            'data' => [
                'id'   => $id,
                'type' => $type,
            ],
        ];

        return $relationships;
    }


}
