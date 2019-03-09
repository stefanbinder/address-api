<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\NotImplementedException;
use App\Exceptions\Api\ResourceObjectTypeError;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class RelationshipDestroyJob implements ShouldQueue
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

        $data = $this->resourceData['data'];

        $relationshipObject   = $model->$relationship();
        $relationshipEloquent = $relationshipObject->getModel();

        if (array_key_exists('id', $data) && array_key_exists('type', $data)) {
            $this->deleteOrDissociateWithModel($relationshipObject, $relationshipEloquent, $data);
        } else {
            foreach ($data as $singleData) {
                $model = $this->deleteOrDissociateWithModel($relationshipObject, $relationshipEloquent, $singleData);
            }
        }

        $model->push();

        return [
            'data' => [
                'message' => 'Successful disconnected the objects'
            ]
        ];
    }

    /**
     * @param Relation $relation
     * @param Model $model
     * @param $data
     * @return Model
     * @throws NotFoundException
     * @throws ResourceObjectTypeError
     * @throws \App\Exceptions\Api\NotImplementedException
     */
    private function deleteOrDissociateWithModel(Relation $relation, Model $model, $data)
    {
        $id   = $data['id'];
        $type = $data['type'];

        if ($model::ID !== $type) {
            throw new ResourceObjectTypeError($type, $model::ID);
        }

        $relationshipModel = $model::find($id);

        if (!$relationshipModel) {
            throw new NotFoundException(get_class($model), $id);
        }

        return ProcessRelations::deleteOrDissociateModelToRelationship($relation, $relationshipModel);
    }

}
