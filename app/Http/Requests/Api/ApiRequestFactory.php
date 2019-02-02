<?php

namespace App\Http\Requests\Api;

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
     * @throws \Exception
     */
    public static function index($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return self::make(CountryIndexRequest::class);
            case 'states': return self::make(StateIndexRequest::class);
            case 'people': return self::make(PersonIndexRequest::class);
            default:
                throw new \Exception("IndexRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws \Exception
     */
    public static function show($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return self::make(CountryShowRequest::class);
            case 'states': return self::make(StateShowRequest::class);
            case 'people': return self::make(PersonShowRequest::class);
            default:
                throw new \Exception("ShowRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws \Exception
     */
    public static function store($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return self::make(CountryStoreRequest::class);
            case 'states': return self::make(StateStoreRequest::class);
            case 'people': return self::make(PersonStoreRequest::class);
            default:
                throw new \Exception("StoreRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws \Exception
     */
    public static function update($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return self::make(CountryUpdateRequest::class);
            case 'states': return self::make(StateUpdateRequest::class);
            case 'people': return self::make(PersonUpdateRequest::class);
            default:
                throw new \Exception("UpdateRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws \Exception
     */
    public static function destroy($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return self::make(CountryDestroyRequest::class);
            case 'states': return self::make(StateDestroyRequest::class);
            case 'people': return self::make(PersonDestroyRequest::class);
            default:
                throw new \Exception("DestroyRequest for '$resourceIdentifier' is not defined in ApiRequestFactory");
        }

    }

}
