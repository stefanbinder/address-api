<?php

namespace App\Jobs\Api;


use App\Jobs\Api\Country\CountryIndexJob;
use App\Jobs\Api\Country\CountryStoreJob;
use App\Jobs\Api\Person\PersonIndexJob;
use App\Jobs\Api\Person\PersonStoreJob;
use App\Jobs\Api\State\StateIndexJob;
use App\Jobs\Api\State\StateStoreJob;
use App\Models\ApiModel;

class ApiJobFactory
{

    /**
     * @param $resourceIdentifier
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public static function index($resourceIdentifier, $data)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryIndexJob::dispatchNow($data);
            case 'states': return StateIndexJob::dispatchNow($data);
            case 'people': return PersonIndexJob::dispatchNow($data);
            default:
                throw new \Exception("IndexJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return mixed
     * @throws \Exception
     */
//    public static function show($resourceIdentifier)
//    {
//
//        switch($resourceIdentifier) {
//            case 'countries': return self::make(CountryShowJob::class);
//            case 'states': return self::make(StateShowJob::class);
//            case 'people': return self::make(PersonShowJob::class);
//            default:
//                throw new \Exception("ShowJob for '$resourceIdentifier' is not defined in ApiJobFactory");
//        }
//
//    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws \Exception
     */
    public static function store($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryStoreJob::class;
            case 'states': return StateStoreJob::class;
            case 'people': return PersonStoreJob::class;
            default:
                throw new \Exception("StoreJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @param $data
     * @return ApiModel
     * @throws \Exception
     */
    public static function storeAndDispatch($resourceIdentifier, $data)
    {
        $class = self::store($resourceIdentifier);
        return $class::dispatchNow($data);
    }

    /**
     * @param $resourceIdentifier
     * @return UpdateJob
     * @throws \Exception
     */
    public static function update($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return self::make(CountryUpdateJob::class);
            case 'states': return self::make(StateUpdateJob::class);
            case 'people': return self::make(PersonUpdateJob::class);
            default:
                throw new \Exception("UpdateJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return DestroyJob
     * @throws \Exception
     */
    public static function destroy($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return self::make(CountryDestroyJob::class);
            case 'states': return self::make(StateDestroyJob::class);
            case 'people': return self::make(PersonDestroyJob::class);
            default:
                throw new \Exception("DestroyJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }


}
