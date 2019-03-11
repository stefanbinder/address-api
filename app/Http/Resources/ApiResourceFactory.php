<?php

namespace App\Http\Resources;

use App\Exceptions\Api\NotImplementedException;
use App\Http\Resources\Country\CountriesResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Media\MediaResource;
use App\Http\Resources\Media\MediasResource;
use App\Http\Resources\Person\PeopleResource;
use App\Http\Resources\Person\PersonResource;
use App\Http\Resources\State\StateResource;
use App\Http\Resources\State\StatesResource;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\Tag\TagsResource;
use App\Http\Resources\Vendor\VendorResource;
use App\Http\Resources\Vendor\VendorsResource;
use App\Models\ApiModel;
use Countable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResourceFactory
{

    /**
     * @param $resourceIdentifier
     * @param ApiModel $model
     * @return ResourceObject
     * @throws NotImplementedException
     */
    public static function resourceObject($resourceIdentifier, ApiModel $model)
    {
        // Put singular and plural, because namings can be different:
        // ApiModel::ID is always plural, but
        // a Relationship can be named singular, eg. $user->role
        switch ($resourceIdentifier) {
            case 'country':
            case 'countries':
                return new CountryResource($model);
            case 'state':
            case 'states':
                return new StateResource($model);
            case 'person':
            case 'people':
                return new PersonResource($model);
            case 'vendor':
            case 'vendors':
                return new VendorResource($model);
            case 'tag':
            case 'tags':
                return new TagResource($model);
            case 'media':
            case 'medias':
                return new MediaResource($model);
            default:
                throw new NotImplementedException("ResourceObject for '$resourceIdentifier' is not defined in ApiResourceFactory");
        }
    }

    /**
     * @param $resourceIdentifier
     * @param $collection
     * @return ResourceCollection
     * @throws NotImplementedException
     */
    public static function resourceCollection($resourceIdentifier, $collection)
    {
        switch ($resourceIdentifier) {
            case 'country':
            case 'countries':
                return new CountriesResource($collection);
            case 'state':
            case 'states':
                return new StatesResource($collection);
            case 'person':
            case 'people':
                return new PeopleResource($collection);
            case 'vendor':
            case 'vendors':
                return new VendorsResource($collection);
            case 'tag':
            case 'tags':
                return new TagsResource($collection);
            case 'media':
            case 'medias':
                return new MediasResource($collection);

            default:
                throw new NotImplementedException("ResourceCollection for '$resourceIdentifier' is not defined in ApiResourceFactory");
        }
    }

    /**
     * Takes an resource-identifier (ID on ApiModel) and checks whether $mixed is an ApiModel or List,
     * returns accordingly a resourceCollection or resourceObject
     *
     * @param $resourceIdentifier
     * @param $mixed
     * @return ResourceObject|ResourceCollection
     * @throws NotImplementedException
     */
    public static function resource($resourceIdentifier, $mixed)
    {
        if ($mixed instanceof ApiModel) {

            return ApiResourceFactory::resourceObject($mixed::ID, $mixed);

        } else if ($mixed instanceof Countable) {

            // Countable should be a list, like Collection, LengthAwarePaginator, Paginator, etc.
            if (count($mixed) > 0 && $mixed[0] instanceof ApiModel) {
                $resourceIdentifier = $mixed[0]::ID;
            }

            return ApiResourceFactory::resourceCollection($resourceIdentifier, $mixed);
        } else {

            throw new NotImplementedException("The given resource isn't ApiModel either a Countable, please implement in ApiResourceFactory@resource");
        }

    }

}
