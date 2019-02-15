<?php

namespace App\Http\Resources;

use App\Http\Resources\Country\CountriesResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Person\PeopleResource;
use App\Http\Resources\Person\PersonResource;
use App\Http\Resources\State\StateResource;
use App\Http\Resources\State\StatesResource;
use App\Models\ApiModel;
use ArrayAccess;
use Countable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResourceFactory
{

    /**
     * @param $resourceIdentifier
     * @param ApiModel $model
     * @return ResourceObject
     * @throws \Exception
     */
    public static function resourceObject($resourceIdentifier, ApiModel $model)
    {
        // Put singular and plural, because namings can be different:
        // ApiModel::ID is always plural, but
        // a Relationship can be named singular, eg. $user->role
        switch($resourceIdentifier) {
            case 'country':
            case 'countries':
                return new CountryResource($model);
            case 'state':
            case 'states':
                return new StateResource($model);
            case 'person':
            case 'people':
                return new PersonResource($model);
            default:
                throw new \Exception("ResourceObject for '$resourceIdentifier' is not defined in ResourceFactory");
        }
    }

    /**
     * @param $resourceIdentifier
     * @param $collection
     * @return ResourceCollection
     * @throws \Exception
     */
    public static function resourceCollection($resourceIdentifier, $collection)
    {
        switch($resourceIdentifier) {
            case 'country':
            case 'countries':
                return new CountriesResource($collection);
            case 'state':
            case 'states':
                return new StatesResource($collection);
            case 'person':
            case 'people':
                return new PeopleResource($collection);
            default:
                throw new \Exception("ResourceCollection for '$resourceIdentifier' is not defined in ResourceFactory");
        }
    }

    /**
     * Takes an resource-identifier (ID on ApiModel) and checks whether $mixed is an ApiModel or List,
     * returns accordingly a resourceCollection or resourceObject
     *
     * @param $resourceIdentifier
     * @param $mixed
     * @return ResourceObject|ResourceCollection
     * @throws \Exception
     */
    public static function resource($resourceIdentifier, $mixed)
    {
        \Log::info("ResourceFactory@resource $resourceIdentifier " . get_class($mixed) . " instanceof Countable: " . ($mixed instanceof Countable));
        if( $mixed instanceof ApiModel) {
            return ResourceFactory::resourceObject($mixed::ID, $mixed);

        } else if( $mixed instanceof Countable ) {

            // Countable should be a list, like Collection, LengthAwarePaginator, Paginator, etc.
            if(count($mixed) > 0 && $mixed[0] instanceof ApiModel) {
                $resourceIdentifier = $mixed[0]::ID;
            }

            return ResourceFactory::resourceCollection($resourceIdentifier, $mixed);
        } else {

            dd("not that null, right?!");
            return null;
        }

    }

}
