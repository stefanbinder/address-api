<?php

namespace App\Jobs\Api;

use App\Jobs\ProcessingSteps\Filter;
use App\Jobs\ProcessingSteps\Ordering;
use App\Jobs\ProcessingSteps\Paginate;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphOneOrMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class StoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $request_data;

    /**
     * Create a new job instance
     * @param $request_data
     */
    public function __construct($request_data)
    {
        $this->model        = $this->getEloquent();
        $this->request_data = $request_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Returns the eloquent-model which is used in the IndexJob
     *
     * @return Model
     */
    abstract protected function getEloquent();

    public function process()
    {
        $resourceObject = $this->request_data['data'];

        if ($this->model::ID !== $resourceObject['type']) {
            // TODO: Exception Handling
            throw new \Exception('ModelID does not fit the given type, cannot create resource');
        }

        $attributes = $this->processAttributes($resourceObject['attributes']);
        $model      = $this->model::create($attributes);

        $this->processRelationships($model, $resourceObject['relationships']);

        // TODO: maybe collect exceptions and return as error-arrays
//        try {
//        } catch (\Exception $e) {
//        }

        $model->save();

        return $model;

    }

    /**
     * Processes the sent attributes
     *
     * Overwrite the method for detailed processing of attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function processAttributes($attributes)
    {
        return $attributes;
    }

    /**
     * Processes the sent relationship data
     *
     * Overwrite the method for detailed processing of attributes.
     *
     * @param ApiModel $model
     * @param $relationships
     * @return void
     * @throws \Exception
     */
    public function processRelationships(ApiModel $model, $relationships)
    {

        foreach ($relationships as $relationship => $resourceData) {
            $relationship = $model->$relationship();

            switch (get_class($relationship)) {
                case HasOne::class:
                    $this->processRelationshipHasOne($model, $relationship, $resourceData);
                    break;
                case HasMany::class:
                    $this->processRelationshipHasMany($model, $relationship, $resourceData);
                    break;
                case BelongsTo::class:
                    $this->processRelationshipBelongsTo($model, $relationship, $resourceData);
                    break;
                case BelongsToMany::class:
                    $this->processRelationshipBelongsToMany($model, $relationship, $resourceData);
                    break;
                case HasManyThrough::class:
                    $this->processRelationshipHasManyThrough($model, $relationship, $resourceData);
                    break;
                case HasOneOrMany::class:
                    $this->processRelationshipHasOneOrMany($model, $relationship, $resourceData);
                    break;
                case MorphMany::class:
                    $this->processRelationshipMorphMany($model, $relationship, $resourceData);
                    break;
                case MorphOne::class:
                    $this->processRelationshipMorphOne($model, $relationship, $resourceData);
                    break;
                case MorphOneOrMany::class:
                    $this->processRelationshipMorphOneOrMany($model, $relationship, $resourceData);
                    break;
                case MorphPivot::class:
                    $this->processRelationshipMorphPivot($model, $relationship, $resourceData);
                    break;
                case MorphTo::class:
                    $this->processRelationshipMorphTo($model, $relationship, $resourceData);
                    break;
                case MorphToMany::class:
                    $this->processRelationshipMorphToMany($model, $relationship, $resourceData);
                    break;
                case Pivot::class:
                    $this->processRelationshipPivot($model, $relationship, $resourceData);
                    break;
                default:
                    throw new \Exception('The relationship ' . get_class($relationship) . ' is not handled by backend');

            }
        }
    }

    /**
     * Process hasOne relationship
     *
     * 1:1
     * $user->hasOne('App\Phone', 'foreign_key', 'local_key');
     *
     *
     * @param ApiModel $model
     * @param HasOne $relationship
     * @param $resourceData
     * @return bool
     * @throws \Exception
     */
    protected function processRelationshipHasOne(ApiModel $model, HasOne $relationship, $resourceData)
    {
        $relationModel = $this->getRelationModel($relationship, $resourceData);

        if( $relationModel ) {
            $relationship->save($relationModel);
        }

        return true;
    }

    /**
     * Process hasMany relationship
     *
     * 1:n
     * $post->hasMany('App\Comment', 'foreign_key', 'local_key');
     *
     * $post->comments()->save($comment)
     * $post->comments()->saveMany([$comment1, $comment2])
     *
     * $post->comments()->create([ 'message' => 'my comment'])
     * $post->comments()->createMany([ 'message' => 'my comment 1'], [ 'message' => 'my comment 2'])
     *
     * @param ApiModel $model
     * @param HasMany $relationship
     * @param $resourceData
     * @throws \Exception
     */
    protected function processRelationshipHasMany(ApiModel $model, HasMany $relationship, $resourceData)
    {

        foreach($resourceData as $resource) {
            $relationModel = $this->getRelationModel($relationship, $resource);

            if( $relationModel ) {
                $relationship->save($relationModel);
            }
        }

    }

    /**
     * Proccess belongsTo relationship
     *
     * $phone->belongsTo('App\User', 'foreign_key', 'other_key');
     * $comment->belongsTo('App\Post', 'foreign_key', 'other_key');
     *
     * $user->phone()->associate($phone)    // sets user_id on phone
     * $user->phone()->dissociate($phone)   // sets user_id to null on phone
     *
     * @param $model
     * @param BelongsTo $relationship
     * @param $resourceData
     * @return bool
     * @throws \Exception
     */
    protected function processRelationshipBelongsTo(ApiModel $model, BelongsTo $relationship, $resourceData)
    {
        $relationModel = $this->getRelationModel($relationship, $resourceData);

        if( $relationModel ) {
            $relationship->associate($relationModel);
        }

        return true;
    }

    /**
     * Process belongsToMany relationship
     *
     * $user->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
     * $role->belongsToMany('App\User', 'role_user', 'role_id', 'user_id);
     *
     * $user->roles()->attach($roleId, [ 'pivot' => 'data' ])
     * $user->roles()->attach([1,2,3])
     *
     * $user->roles()->detach($roleId)
     * $user->roles()->detach() !! Deletes all !!
     *
     * $user->roles()->sync([1, 2, 3 => ['pivot' => 'data'] ]])
     * $user->roles()->syncWithoutDetaching([4, 5, 6])
     *
     * $user->roles()->save($role, ['pivot' => 'data'])
     * @param $model
     * @param Relation $relationship
     * @param $resourceData
     */
    protected function processRelationshipBelongsToMany(Model $model, Relation $relationship, $resourceData)
    {

    }

    protected function processRelationshipHasManyThrough(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipHasOneOrMany(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipMorphMany(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipMorphOne(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipMorphOneOrMany(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipMorphPivot(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipMorphTo(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipMorphToMany(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    protected function processRelationshipPivot(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }


    /**
     * HELPER FUNCTIONS
     */


    protected function checkResourceObjectHasType($resourceObject)
    {
        if( !array_key_exists('type', $resourceObject)) {
            throw new \Exception("In the relationships data either ID or TYPE is not given!");
        }

        // TODO: maybe check with a whitelist of ALL available objects...

        return true;
    }

    /**
     * @param Relation $relationship
     * @param $resourceData
     * @return \Illuminate\Database\Eloquent\Collection|Model|Model[]|Relation|Relation[]|null
     * @throws \Exception
     */
    protected function getRelationModel(Relation $relationship, $resourceData)
    {
        $resourceData = $resourceData['data'];

        $this->checkResourceObjectHasType($resourceData);

        $type = $resourceData['type'];

        $relationModelClass = $relationship->getModel();

        if( $type !== $relationModelClass::ID ) {
            throw new \Exception('Your given relationship-type "'.$type.'" does not fit with our ID "'.$relationModelClass::ID.'"');
        }

        $relationModel = null;

        if( array_key_exists('id', $resourceData)) {
            $relationModel = $relationModelClass::find($resourceData['id']);
        }

        if( array_key_exists('attributes', $resourceData) ) {
            if( $relationModel ) {
                $relationModel->update($resourceData['attributes']);
            } else {
                $relationModel = $relationModelClass::create($resourceData['attributes']);
            }
        }

        return $relationModel;
    }


}
