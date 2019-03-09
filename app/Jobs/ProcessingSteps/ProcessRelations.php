<?php

namespace App\Jobs\ProcessingSteps;

use App\Exceptions\Api\Jobs\ValidationException;
use App\Exceptions\Api\NotImplementedException;
use App\Exceptions\Api\ResourceObjectTypeError;
use App\Http\Requests\Api\ApiRequestFactory;
use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Validator;

class ProcessRelations
{

    /**
     * Processes the sent relationship data
     *
     * Overwrite the method for detailed processing of attributes.
     *
     * @param ApiModel $model
     * @param $relationships
     * @return void
     * @throws NotImplementedException
     * @throws ValidationException
     */
    public static function processRelationships(ApiModel $model, $relationships)
    {
        foreach ($relationships as $relationshipId => $resourceData) {
            $relationship = $model->$relationshipId();
            switch (get_class($relationship)) {
                case HasOne::class:
                    self::processRelationshipHasOne($model, $relationship, $resourceData);
                    break;
                case HasMany::class:
                    self::processRelationshipHasMany($model, $relationship, $resourceData);
                    break;
                case BelongsTo::class:
                    self::processRelationshipBelongsTo($model, $relationship, $resourceData);
                    break;
                case BelongsToMany::class:
                    self::processRelationshipBelongsToMany($model, $relationship, $resourceData);
                    break;
                case HasManyThrough::class:
                    self::processRelationshipHasManyThrough($model, $relationship, $resourceData);
                    break;
                case MorphMany::class:
                    self::processRelationshipMorphMany($model, $relationship, $resourceData);
                    break;
                case MorphOne::class:
                    self::processRelationshipMorphOne($model, $relationship, $resourceData);
                    break;
                case MorphPivot::class:
                    self::processRelationshipMorphPivot($model, $relationship, $resourceData);
                    break;
                case MorphTo::class:
                    self::processRelationshipMorphTo($model, $relationship, $resourceData);
                    break;
                case MorphToMany::class:
                    self::processRelationshipMorphToMany($model, $relationship, $resourceData);
                    break;
                case Pivot::class:
                    self::processRelationshipPivot($model, $relationship, $resourceData);
                    break;
                default:
                    throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not handled by backend');
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
     * @throws ValidationException
     * @throws NotImplementedException
     */
    public static function processRelationshipHasOne(ApiModel $model, HasOne $relationship, $resourceData)
    {
        $relationModel = self::getAndStoreOrUpdateRelationModel($relationship, $resourceData);

        if ($relationModel instanceof ApiModel) {
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
     * @throws ValidationException
     * @throws NotImplementedException
     */
    public static function processRelationshipHasMany(ApiModel $model, HasMany $relationship, $resourceData)
    {
        foreach ($resourceData as $resource) {
            $relationModel = self::getAndStoreOrUpdateRelationModel($relationship, $resource);

            if ($relationModel) {
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
     * @param ApiModel $model
     * @param BelongsTo $relationship
     * @param $resourceData
     * @return bool
     * @throws NotImplementedException
     * @throws ValidationException
     */
    public static function processRelationshipBelongsTo(ApiModel $model, BelongsTo $relationship, $resourceData)
    {
        $relationModel = self::getAndStoreOrUpdateRelationModel($relationship, $resourceData);

        if ($relationModel) {
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
    public static function processRelationshipBelongsToMany(Model $model, Relation $relationship, $resourceData)
    {

    }

    public static function processRelationshipHasManyThrough(Model $model, $relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphMany(Model $model, $relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphOne(Model $model, $relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphPivot(Model $model, $relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphTo(Model $model, $relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphToMany(Model $model, $relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipPivot(Model $model, $relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }


    /**
     * @param Relation $relationship
     * @param $type
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|Model[]|Relation|Relation[]|null
     */
    public static function getModelOfRelationshipWithId(Relation $relationship, $id)
    {
        $relationModelClass = $relationship->getModel();
        $relationModel      = null;

        if ($id) {
            $relationModel = $relationModelClass::find($id);
        }

        return $relationModel;
    }

    /**
     * Gets the model of the relationship and tries to store or update the model with the given $resourceData
     * The ID is retrieved by $resourceData
     *
     * @param Relation $relationship
     * @param $resourceData
     * @return \Illuminate\Database\Eloquent\Collection|Model|Model[]|Relation|Relation[]|null
     * @throws NotImplementedException
     * @throws ValidationException
     */
    public static function getAndStoreOrUpdateRelationModel(Relation $relationship, $resourceData)
    {
        // TODO: refactor and make method smaller. Break down into:
        // storeRelationModel
        // updateRelationModel

        $id   = $resourceData['data']['id'] ?? null;
        $type = $resourceData['data']['type'];

        $relationModel = self::getModelOfRelationshipWithId($relationship, $id);

        if (array_key_exists('attributes', $resourceData['data'])) {

            if ($relationModel) {

                $rule      = ApiRequestFactory::rules($type);
                $validator = Validator::make($resourceData, $rule::update($relationModel));

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $validatedData = $validator->validate();
                $relationModel->update($validatedData['data']['attributes']);
            } else {

                $rule      = ApiRequestFactory::rules($type);
                $validator = Validator::make($resourceData, $rule::store());

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $relationModelClass = $relationship->getModel();

                $validatedData = $validator->validate();
                $relationModel = $relationModelClass::create($validatedData['data']['attributes']);
            }
        }

        return $relationModel;
    }

}
