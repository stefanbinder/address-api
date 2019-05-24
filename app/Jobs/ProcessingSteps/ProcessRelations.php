<?php

namespace App\Jobs\ProcessingSteps;

use App\Exceptions\Api\Jobs\NotFoundRelatedException;
use App\Exceptions\Api\Jobs\ValidationException;
use App\Exceptions\Api\NotFoundException;
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
use Illuminate\Support\Collection;
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
            self::processRelationship($relationship, $resourceData);
        }
    }

    /**
     * Processes the sent relationship data
     *
     * Overwrite the method for detailed processing of attributes.
     *
     * @param $relationship
     * @param $resourceData
     * @return Collection|ApiModel|static|null
     * @throws NotImplementedException
     * @throws ValidationException
     */
    public static function processRelationship($relationship, $resourceData)
    {
        switch (get_class($relationship)) {
            case HasOne::class:
                return self::processRelationshipHasOne($relationship, $resourceData);
                break;
            case HasMany::class:
                return self::processRelationshipHasMany($relationship, $resourceData);
                break;
            case BelongsTo::class:
                return self::processRelationshipBelongsTo($relationship, $resourceData);
                break;
            case BelongsToMany::class:
                return self::processRelationshipBelongsToMany($relationship, $resourceData);
                break;
            case HasManyThrough::class:
                return self::processRelationshipHasManyThrough($relationship, $resourceData);
                break;
            case MorphMany::class:
                return self::processRelationshipMorphMany($relationship, $resourceData);
                break;
            case MorphOne::class:
                return self::processRelationshipMorphOne($relationship, $resourceData);
                break;
            case MorphPivot::class:
                return self::processRelationshipMorphPivot($relationship, $resourceData);
                break;
            case MorphTo::class:
                return self::processRelationshipMorphTo($relationship, $resourceData);
                break;
            case MorphToMany::class:
                return self::processRelationshipMorphToMany($relationship, $resourceData);
                break;
            case Pivot::class:
                return self::processRelationshipPivot($relationship, $resourceData);
                break;
            default:
                throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not handled by backend');
        }
    }

    /**
     * Process hasOne relationship
     *
     * 1:1
     * $user->hasOne('App\Phone', 'foreign_key', 'local_key');
     *
     *
     * @param HasOne $hasOne
     * @param $resourceData
     * @return ApiModel|static|null
     * @throws ValidationException
     * @throws NotImplementedException
     */
    public static function processRelationshipHasOne(HasOne $hasOne, $resourceData)
    {
        $relationModel = self::getAndStoreOrUpdateRelationModel($hasOne, $resourceData);

        if ($relationModel instanceof ApiModel) {
            $hasOne->save($relationModel);
        }

        return $relationModel;
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
     * @param HasMany $hasMany
     * @param $resourceData
     * @return Collection|ApiModel|static|null
     * @throws ValidationException
     * @throws NotImplementedException
     * @throws ResourceObjectTypeError
     */
    public static function processRelationshipHasMany(HasMany $hasMany, $resourceData)
    {

        if( is_identifier_object($resourceData) ) {

            $relationModel = self::getAndStoreOrUpdateRelationModel($hasMany, $resourceData);
            $hasMany->save($relationModel);

            return $relationModel;

        } else if ( is_array($resourceData) ) {

            $list = collect();

            foreach ($resourceData as $resource) {
                $relationModel = self::getAndStoreOrUpdateRelationModel($hasMany, $resource);

                if ($relationModel) {
                    $hasMany->save($relationModel);
                    $list->push($relationModel);
                }
            }

            return $list;
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
     * @param BelongsTo $belongsTo
     * @param $resourceData
     * @return ApiModel|static|null
     * @throws NotImplementedException
     * @throws ResourceObjectTypeError
     * @throws ValidationException
     */
    public static function processRelationshipBelongsTo(BelongsTo $belongsTo, $resourceData)
    {
        $relationModel = self::getAndStoreOrUpdateRelationModel($belongsTo, $resourceData);

        if ($relationModel) {
            $belongsTo->associate($relationModel);
        }

        return $relationModel;
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
     * @param BelongsToMany $belongsToMany
     * @param $resourceData
     * @return Collection|ApiModel|static|null
     * @throws NotImplementedException
     * @throws ResourceObjectTypeError
     * @throws ValidationException
     */
    public static function processRelationshipBelongsToMany(BelongsToMany $belongsToMany, $resourceData)
    {

        // Either get a list of entries => sync whole list
        // Or get a single ID Object => add it to list

        if( is_identifier_object($resourceData) ) {

            $relationModel = self::getAndStoreOrUpdateRelationModel($belongsToMany, $resourceData);

            if( $relationModel ) {
                $belongsToMany->syncWithoutDetaching([$relationModel->id]);
            }

            return $relationModel;

        } else if( is_array($resourceData) ) {

            $list = collect();

            foreach($resourceData as $resource) {

                $relationModel = self::getAndStoreOrUpdateRelationModel($belongsToMany, $resource);
                $list->push($relationModel);
            }

            $belongsToMany->sync($list->pluck('id'));
            return $list;

        }

        return null;
    }

    public static function processRelationshipHasManyThrough($relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphMany($relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphOne($relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphPivot($relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    public static function processRelationshipMorphTo($relationship, $resourceData)
    {
        dd($resourceData, $relationship);
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }

    /**
     * @param MorphToMany $morphToMany
     * @param $resourceData
     * @return ProcessRelations|ApiModel|null
     * @throws NotImplementedException
     * @throws ResourceObjectTypeError
     * @throws ValidationException
     */
    public static function processRelationshipMorphToMany(MorphToMany $morphToMany, $resourceData)
    {
        // Either get a list of entries => sync whole list
        // Or get a single ID Object => add it to list

        if( is_identifier_object($resourceData) ) {

            $relationModel = self::getAndStoreOrUpdateRelationModel($morphToMany, $resourceData);

            if( $relationModel ) {
                $morphToMany->syncWithoutDetaching([$relationModel->id]);
            }

            return $relationModel;

        } else if( is_array($resourceData) ) {

            $list = collect();

            foreach($resourceData as $resource) {

                $relationModel = self::getAndStoreOrUpdateRelationModel($morphToMany, $resource);
                $list->push($relationModel);
            }

            $morphToMany->sync($list->pluck('id'));

        }

        return null;

    }

    public static function processRelationshipPivot($relationship, $resourceData)
    {
        throw new NotImplementedException('The relationship ' . get_class($relationship) . ' is not implemented yet by backend!');
    }


    /**
     * @param Relation $relationship
     * @param $id
     * @return ApiModel|static|null
     */
    public static function getModelOfRelationshipWithId(Relation $relationship, $id)
    {
        $relationModelClass = $relationship->getModel();
        $relationModel      = null;

        if ($id) {
            $relationModel = $relationModelClass::find($id);
        }

        // TODO: result of find also can be an array, pls consider here somehow

        return $relationModel;
    }

    /**
     * Gets the model of the relationship and tries to store or update the model with the given $resourceData
     * The ID is retrieved by $resourceData
     *
     * @param Relation $relation
     * @param $resourceData
     * @return ApiModel|static|null
     * @throws NotImplementedException
     * @throws ValidationException
     * @throws ResourceObjectTypeError
     */
    public static function getAndStoreOrUpdateRelationModel(Relation $relation, $resourceData)
    {
        // TODO: refactor and make method smaller. Break down into:
        // storeRelationModel
        // updateRelationModel

        if( ! is_identifier_object($resourceData) ) {
            throw new ResourceObjectTypeError('is empty, ', null);
        }

        $id   = $resourceData['data']['id'] ?? null;
        $type = $resourceData['data']['type'];

        $eloquent = $relation->getModel();

        // If the given type in the request isn't the same as our eloquent-model, which he wants to store
        // we give back an error, that we can't assign and validate the request
        if($eloquent::ID !== $resourceData['data']['type']) {
            throw new ResourceObjectTypeError($resourceData['data']['type'], $eloquent::ID);
        }

        $relationModel = self::getModelOfRelationshipWithId($relation, $id);

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

                $validatedData = $validator->validate();
                $relationModel = $eloquent::create($validatedData['data']['attributes']);
            }
        }

        return $relationModel;
    }

    /**
     * Takes a Identifier Object and returns the model
     *
     * @param ApiModel $eloquent
     * @param $identifierObject
     * @return mixed
     * @throws NotFoundException
     * @throws ResourceObjectTypeError
     */
    public static function getModelFromIO( ApiModel $eloquent, $identifierObject )
    {
        $id   = $identifierObject['id'];
        $type = $identifierObject['type'];

        $model = $eloquent::find($id);

        if (!$model) {
            throw new NotFoundException(get_class($eloquent), $id);
        }

        if ($model::ID !== $type) {
            throw new ResourceObjectTypeError($type, $model::ID);
        }

        return $model;
    }

    /**
     * Takes a relation and Identifier Object and searchs for the model
     * The model will be attached/saved/associated to the relationship,
     * depending which type of relation is given.
     *
     * @param Relation $relation
     * @param ApiModel $eloquent
     * @param $identifierObject
     * @return Model
     *
     * @throws NotFoundException
     * @throws NotImplementedException
     * @throws ResourceObjectTypeError
     */
    public static function saveOrAssociateEloquentWithIOToRelationship( Relation $relation, ApiModel $eloquent, $identifierObject )
    {
        $model = self::getModelFromIO($eloquent, $identifierObject);
        return self::saveOrAssociateModelToRelationship($relation, $model);
    }

    /**
     * Takes a relation and Identifier Object and searchs for the model
     * The model will be detached/deleted/dissociated to the relationship,
     * depending which type of relation is given.
     *
     * @param Relation $relation
     * @param ApiModel $eloquent
     * @param $identifierObject
     * @return Model
     * @throws NotFoundException
     * @throws NotImplementedException
     * @throws ResourceObjectTypeError
     */
    public static function deleteOrDissociateEloquentWithIOToRelationship(Relation $relation, ApiModel $eloquent, $identifierObject )
    {
        $model = self::getModelFromIO($eloquent, $identifierObject);
        return self::deleteOrDissociateModelToRelationship($relation, $model);
    }

    /**
     * Takes a relation and attachs/saves/associate the model to the relationship,
     * depending which type of relation is given.
     *
     * @param Relation $relation
     * @param ApiModel $model
     * @return ApiModel|null
     * @throws NotImplementedException
     */
    public static function saveOrAssociateModelToRelationship( Relation $relation, ApiModel $model )
    {
        switch (get_class($relation)) {
            case HasOne::class:
            case HasMany::class:
            case BelongsToMany::class:
            case MorphMany::class:
            case MorphOne::class:
            case MorphToMany::class:
                $relation->save($model);
                return $model;
            case BelongsTo::class:
            case MorphTo::class:
                $relation->associate($model);
                return $model;
            case HasManyThrough::class:
            case MorphPivot::class:
            case Pivot::class:
                // TODO: implement that
                throw new NotImplementedException('The pivot relationships are not implemented');
                break;
        }

        return null;
    }

    /**
     * Takes a relation and deletes/detaches/dissociate the model to the relationship,
     * depending which type of relation is given.
     *
     * @param Relation $relationship
     * @param $model
     * @return Model
     * @throws NotImplementedException
     */
    public static function deleteOrDissociateModelToRelationship( Relation $relationship, ApiModel $model )
    {
        switch (get_class($relationship)) {
            case HasMany::class:
                // BelongsTo is the other side of relation, therefore the foreign_key is stored in given ApiModel
                $model->setAttribute($relationship->getForeignKeyName(), null);
                $model->save();
                return $model;
                break;
            case BelongsTo::class:
                return $relationship->dissociate();
                break;
            case HasOne::class:
            case BelongsToMany::class:
            case MorphMany::class:
            case MorphOne::class:
            case MorphToMany::class:
            case MorphTo::class:
            case HasManyThrough::class:
            case MorphPivot::class:
            case Pivot::class:
                // TODO: implement that
                throw new NotImplementedException('The pivot relationships are not implemented');
                break;
        }

        return null;

    }

}
