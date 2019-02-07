<?php

namespace App\Jobs\Api;


use App\Jobs\Api\Country\CountryDestroyJob;
use App\Jobs\Api\Country\CountryIndexJob;
use App\Jobs\Api\Country\CountryRelatedDestroyJob;
use App\Jobs\Api\Country\CountryRelatedIndexJob;
use App\Jobs\Api\Country\CountryRelatedStoreJob;
use App\Jobs\Api\Country\CountryRelatedUpdateJob;
use App\Jobs\Api\Country\CountryStoreJob;
use App\Jobs\Api\Country\CountryUpdateJob;
use App\Jobs\Api\Person\PersonDestroyJob;
use App\Jobs\Api\Person\PersonIndexJob;
use App\Jobs\Api\Person\PersonRelatedDestroyJob;
use App\Jobs\Api\Person\PersonRelatedIndexJob;
use App\Jobs\Api\Person\PersonRelatedStoreJob;
use App\Jobs\Api\Person\PersonRelatedUpdateJob;
use App\Jobs\Api\Person\PersonStoreJob;
use App\Jobs\Api\Person\PersonUpdateJob;
use App\Jobs\Api\State\StateDestroyJob;
use App\Jobs\Api\State\StateIndexJob;
use App\Jobs\Api\State\StateRelatedDestroyJob;
use App\Jobs\Api\State\StateRelatedIndexJob;
use App\Jobs\Api\State\StateRelatedStoreJob;
use App\Jobs\Api\State\StateRelatedUpdateJob;
use App\Jobs\Api\State\StateStoreJob;
use App\Jobs\Api\State\StateUpdateJob;
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
     * @return string
     * @throws \Exception
     */
    public static function update($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryUpdateJob::class;
            case 'states': return StateUpdateJob::class;
            case 'people': return PersonUpdateJob::class;
            default:
                throw new \Exception("UpdateJob for '$resourceIdentifier' is not defined in ApiJobFactory");
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
            case 'countries': return CountryDestroyJob::class;
            case 'states': return StateDestroyJob::class;
            case 'people': return PersonDestroyJob::class;
            default:
                throw new \Exception("DestroyJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }


    /**
     * @param $resourceIdentifier
     * @return mixed
     * @throws \Exception
     */
    public static function relatedIndex($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryRelatedIndexJob::class;
            case 'states': return StateRelatedIndexJob::class;
            case 'people': return PersonRelatedIndexJob::class;
            default:
                throw new \Exception("IndexJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return mixed
     * @throws \Exception
     */
//    public static function relatedShow($resourceIdentifier)
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
    public static function relatedStore($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryRelatedStoreJob::class;
            case 'states': return StateRelatedStoreJob::class;
            case 'people': return PersonRelatedStoreJob::class;
            default:
                throw new \Exception("StoreJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws \Exception
     */
    public static function relatedUpdate($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryRelatedUpdateJob::class;
            case 'states': return StateRelatedUpdateJob::class;
            case 'people': return PersonRelatedUpdateJob::class;
            default:
                throw new \Exception("UpdateJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws \Exception
     */
    public static function relatedDestroy($resourceIdentifier)
    {

        switch($resourceIdentifier) {
            case 'countries': return CountryRelatedDestroyJob::class;
            case 'states': return StateRelatedDestroyJob::class;
            case 'people': return PersonRelatedDestroyJob::class;
            default:
                throw new \Exception("DestroyJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

}
