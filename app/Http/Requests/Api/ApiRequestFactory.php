<?php

namespace App\Http\Requests\Api;

use App\Exceptions\Api\NotImplementedException;
use App\Http\Requests\Api\Country\CountryDestroyRequest;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Http\Requests\Api\Country\CountryShowRequest;
use App\Http\Requests\Api\Country\CountryStoreRequest;
use App\Http\Requests\Api\Country\CountryUpdateRequest;
use App\Http\Requests\Api\Person\PersonDestroyRequest;
use App\Http\Requests\Api\Person\PersonIndexRequest;
use App\Http\Requests\Api\Person\PersonShowRequest;
use App\Http\Requests\Api\Person\PersonStoreRequest;
use App\Http\Requests\Api\Person\PersonUpdateRequest;
use App\Http\Requests\Api\State\StateDestroyRequest;
use App\Http\Requests\Api\State\StateIndexRequest;
use App\Http\Requests\Api\State\StateShowRequest;
use App\Http\Requests\Api\State\StateStoreRequest;
use App\Http\Requests\Api\State\StateUpdateRequest;
use Illuminate\Support\Facades\App;

class ApiRequestFactory
{

    public static function make($class)
    {
        return App::make($class);
    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function index($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryIndexRequest::class;
            case 'states': return StateIndexRequest::class;
            case 'people': return PersonIndexRequest::class;
            default:
                throw new NotImplementedException("IndexRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function show($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryShowRequest::class;
            case 'states': return StateShowRequest::class;
            case 'people': return PersonShowRequest::class;
            default:
                throw new NotImplementedException("ShowRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function store($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryStoreRequest::class;
            case 'states': return StateStoreRequest::class;
            case 'people': return PersonStoreRequest::class;
            default:
                throw new NotImplementedException("StoreRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function update($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryUpdateRequest::class;
            case 'states': return StateUpdateRequest::class;
            case 'people': return PersonUpdateRequest::class;
            default:
                throw new NotImplementedException("UpdateRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function destroy($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryDestroyRequest::class;
            case 'states': return StateDestroyRequest::class;
            case 'people': return PersonDestroyRequest::class;
            default:
                throw new NotImplementedException("DestroyRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

}
