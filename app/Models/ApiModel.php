<?php

namespace App\Models;

use App\Exceptions\Api\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

abstract class ApiModel extends Model
{

    use SoftDeletes;

    const ID = null;

    public function get_identifier_object() {
        return [
            'id' => $this->id,
            'type' => static::ID,
        ];
    }

    /**
     * Retrieves the identifier object from a relationship (single or list)
     * @param $model
     * @param $relationship
     * @return array
     * @throws \Exception
     */
    public function get_identifier_object_of_relation($relationship)
    {
        $identifier_object = null;

        if (method_exists($this, $relationship)) {
            $relationshipModelOrCollection = $this->$relationship;

            // The value is not set, so already return null
            if( ! $relationshipModelOrCollection ) {
                return null;
            }

            // Value is set, so it can either be a Collection of Models, or single Model
            if ($relationshipModelOrCollection instanceof Collection) {

                $identifier_object = $relationshipModelOrCollection->map(function ($model) {
                    // The method get_identifier_object is a generic function on ApiModel, all models should extends that class.
                    return $model->get_identifier_object();
                });

            } else {
                $identifier_object = $relationshipModelOrCollection->get_identifier_object();
            }

        } else {
            throw new \Exception('Relationship "' . $relationship . '" does not exist');
        }

        return $identifier_object;
    }

    /**
     * @param mixed $value
     * @return Model|null
     * @throws NotFoundException
     */
    public function resolveRouteBinding($value)
    {
        $model = $this->find($value);

        if( !$model ) {
            throw new NotFoundException($this::ID, $value);
        }

        return $model;
    }

}
