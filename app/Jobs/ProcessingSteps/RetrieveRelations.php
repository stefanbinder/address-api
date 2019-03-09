<?php

namespace App\Jobs\ProcessingSteps;

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
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class RetrieveRelations
{

    /**
     * Processes the sent relationship data
     *
     * Overwrite the method for detailed processing of attributes.
     *
     * @param ApiModel $model
     * @param Relation $relationships
     * @return array|null
     * @throws ResourceObjectTypeError
     */
    public static function retrieveRelation(ApiModel $model, $relation)
    {

        try {
            switch (get_class($relation)) {
                case HasOne::class:

                    break;
                case HasMany::class:

                    break;
                case BelongsTo::class:

                    break;
                case BelongsToMany::class:

                    break;
                case HasManyThrough::class:

                    break;
                case MorphMany::class:

                    break;
                case MorphOne::class:

                    break;
                case MorphPivot::class:

                    break;
                case MorphTo::class:

                    break;
                case MorphToMany::class:

                    break;
                case Pivot::class:

                    break;
                default:
                    throw new \Exception('The relationship ' . get_class($relation) . ' is not handled by backend');

            }
        } catch (ValidationException $e) {
            $validationErrors = array_merge($validationErrors, $e->errors());
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
     * @throws ResourceObjectTypeError
     * @throws ValidationException
     */
    public static function processRelationshipHasOne(ApiModel $model, HasOne $relationship, $resourceData)
    {
        $relationModel = self::getAndStoreOrUpdateRelationModel($relationship, $resourceData);

        if (!$relationModel instanceof MessageBag) {
            return $relationModel;
        }

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
     * @throws ResourceObjectTypeError
     * @throws ValidationException
     * @throws \App\Exceptions\Api\NotImplementedException
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
     * @throws ResourceObjectTypeError
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
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphMany(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphOne(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphPivot(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphTo(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphToMany(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipPivot(Model $model, $relationship, $resourceData)
    {
        throw new \Exception('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

}
