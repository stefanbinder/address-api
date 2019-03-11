<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\NotImplementedException;
use App\Jobs\Api\Country\CountryDestroyJob;
use App\Jobs\Api\Country\CountryIndexJob;
use App\Jobs\Api\Country\CountryRelatedDestroyJob;
use App\Jobs\Api\Country\CountryRelatedIndexJob;
use App\Jobs\Api\Country\CountryRelatedStoreJob;
use App\Jobs\Api\Country\CountryRelatedUpdateJob;
use App\Jobs\Api\Country\CountryStoreJob;
use App\Jobs\Api\Country\CountryUpdateJob;
use App\Jobs\Api\Media\MediaDestroyJob;
use App\Jobs\Api\Media\MediaIndexJob;
use App\Jobs\Api\Media\MediaRelatedDestroyJob;
use App\Jobs\Api\Media\MediaRelatedIndexJob;
use App\Jobs\Api\Media\MediaRelatedStoreJob;
use App\Jobs\Api\Media\MediaRelatedUpdateJob;
use App\Jobs\Api\Media\MediaStoreJob;
use App\Jobs\Api\Media\MediaUpdateJob;
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
use App\Jobs\Api\Tag\TagDestroyJob;
use App\Jobs\Api\Tag\TagIndexJob;
use App\Jobs\Api\Tag\TagRelatedDestroyJob;
use App\Jobs\Api\Tag\TagRelatedIndexJob;
use App\Jobs\Api\Tag\TagRelatedStoreJob;
use App\Jobs\Api\Tag\TagRelatedUpdateJob;
use App\Jobs\Api\Tag\TagStoreJob;
use App\Jobs\Api\Tag\TagUpdateJob;
use App\Jobs\Api\Vendor\VendorDestroyJob;
use App\Jobs\Api\Vendor\VendorIndexJob;
use App\Jobs\Api\Vendor\VendorRelatedDestroyJob;
use App\Jobs\Api\Vendor\VendorRelatedIndexJob;
use App\Jobs\Api\Vendor\VendorRelatedStoreJob;
use App\Jobs\Api\Vendor\VendorRelatedUpdateJob;
use App\Jobs\Api\Vendor\VendorStoreJob;
use App\Jobs\Api\Vendor\VendorUpdateJob;

class ApiJobFactory
{

    /**
     * @param $resourceIdentifier
     * @param $data
     * @return mixed
     * @throws NotImplementedException
     */
    public static function index($resourceIdentifier, $data)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryIndexJob::dispatchNow($data);
            case 'states':
                return StateIndexJob::dispatchNow($data);
            case 'people':
                return PersonIndexJob::dispatchNow($data);
            case 'vendors':
                return VendorIndexJob::dispatchNow($data);
            case 'tags':
                return TagIndexJob::dispatchNow($data);
            case 'media':
                return MediaIndexJob::dispatchNow($data);
            default:
                throw new NotImplementedException("IndexJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return mixed
     * @throws NotImplementedException
     */
//    public static function show($resourceIdentifier)
//    {
//
//        switch($resourceIdentifier) {
//            case 'countries': return self::make(CountryShowJob::class);
//            case 'states': return self::make(StateShowJob::class);
//            case 'people': return self::make(PersonShowJob::class);
//            default:
//                throw new NotImplementedException("ShowJob for '$resourceIdentifier' is not defined in ApiJobFactory");
//        }
//
//    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function store($resourceIdentifier)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryStoreJob::class;
            case 'states':
                return StateStoreJob::class;
            case 'people':
                return PersonStoreJob::class;
            case 'vendors':
                return VendorStoreJob::class;
            case 'tags':
                return TagStoreJob::class;
            case 'media':
                return MediaStoreJob::class;
            default:
                throw new NotImplementedException("StoreJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function update($resourceIdentifier)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryUpdateJob::class;
            case 'states':
                return StateUpdateJob::class;
            case 'people':
                return PersonUpdateJob::class;
            case 'vendors':
                return VendorUpdateJob::class;
            case 'tags':
                return TagUpdateJob::class;
            case 'media':
                return MediaUpdateJob::class;
            default:
                throw new NotImplementedException("UpdateJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function destroy($resourceIdentifier)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryDestroyJob::class;
            case 'states':
                return StateDestroyJob::class;
            case 'people':
                return PersonDestroyJob::class;
            case 'vendors':
                return VendorDestroyJob::class;
            case 'tags':
                return TagDestroyJob::class;
            case 'media':
                return MediaDestroyJob::class;
            default:
                throw new NotImplementedException("DestroyJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }


    /**
     * @param $resourceIdentifier
     * @return mixed
     * @throws NotImplementedException
     */
    public static function relatedIndex($resourceIdentifier)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryRelatedIndexJob::class;
            case 'states':
                return StateRelatedIndexJob::class;
            case 'people':
                return PersonRelatedIndexJob::class;
            case 'vendors':
                return VendorRelatedIndexJob::class;
            case 'tags':
                return TagRelatedIndexJob::class;
            case 'media':
                return MediaRelatedIndexJob::class;
            default:
                throw new NotImplementedException("IndexJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return mixed
     * @throws NotImplementedException
     */
//    public static function relatedShow($resourceIdentifier)
//    {
//
//        switch($resourceIdentifier) {
//            case 'countries': return self::make(CountryShowJob::class);
//            case 'states': return self::make(StateShowJob::class);
//            case 'people': return self::make(PersonShowJob::class);
//            default:
//                throw new NotImplementedException("ShowJob for '$resourceIdentifier' is not defined in ApiJobFactory");
//        }
//
//    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function relatedStore($resourceIdentifier)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryRelatedStoreJob::class;
            case 'states':
                return StateRelatedStoreJob::class;
            case 'people':
                return PersonRelatedStoreJob::class;
            case 'vendors':
                return VendorRelatedStoreJob::class;
            case 'tags':
                return TagRelatedStoreJob::class;
            case 'media':
                return MediaRelatedStoreJob::class;
            default:
                throw new NotImplementedException("StoreJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function relatedUpdate($resourceIdentifier)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryRelatedUpdateJob::class;
            case 'states':
                return StateRelatedUpdateJob::class;
            case 'people':
                return PersonRelatedUpdateJob::class;
            case 'vendors':
                return VendorRelatedUpdateJob::class;
            case 'tags':
                return TagRelatedUpdateJob::class;
            case 'media':
                return MediaRelatedUpdateJob::class;
            default:
                throw new NotImplementedException("UpdateJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

    /**
     * @param $resourceIdentifier
     * @return string
     * @throws NotImplementedException
     */
    public static function relatedDestroy($resourceIdentifier)
    {

        switch ($resourceIdentifier) {
            case 'countries':
                return CountryRelatedDestroyJob::class;
            case 'states':
                return StateRelatedDestroyJob::class;
            case 'people':
                return PersonRelatedDestroyJob::class;
            case 'vendors':
                return VendorRelatedDestroyJob::class;
            case 'tags':
                return TagRelatedDestroyJob::class;
            case 'media':
                return MediaRelatedDestroyJob::class;
            default:
                throw new NotImplementedException("DestroyJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

}
