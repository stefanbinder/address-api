<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\NotImplementedException;
use App\Jobs\Api\City\CityDestroyJob;
use App\Jobs\Api\City\CityIndexJob;
use App\Jobs\Api\City\CityStoreJob;
use App\Jobs\Api\City\CityUpdateJob;
use App\Jobs\Api\Country\CountryDestroyJob;
use App\Jobs\Api\Country\CountryIndexJob;
use App\Jobs\Api\Country\CountryStoreJob;
use App\Jobs\Api\Country\CountryUpdateJob;
use App\Jobs\Api\MediaObject\MediaObjectDestroyJob;
use App\Jobs\Api\MediaObject\MediaObjectIndexJob;
use App\Jobs\Api\MediaObject\MediaObjectStoreJob;
use App\Jobs\Api\MediaObject\MediaObjectUpdateJob;
use App\Jobs\Api\Person\PersonDestroyJob;
use App\Jobs\Api\Person\PersonIndexJob;
use App\Jobs\Api\Person\PersonStoreJob;
use App\Jobs\Api\Person\PersonUpdateJob;
use App\Jobs\Api\Region\RegionDestroyJob;
use App\Jobs\Api\Region\RegionIndexJob;
use App\Jobs\Api\Region\RegionStoreJob;
use App\Jobs\Api\Region\RegionUpdateJob;
use App\Jobs\Api\State\StateDestroyJob;
use App\Jobs\Api\State\StateIndexJob;
use App\Jobs\Api\State\StateStoreJob;
use App\Jobs\Api\State\StateUpdateJob;
use App\Jobs\Api\Tag\TagDestroyJob;
use App\Jobs\Api\Tag\TagIndexJob;
use App\Jobs\Api\Tag\TagStoreJob;
use App\Jobs\Api\Tag\TagUpdateJob;
use App\Jobs\Api\Vendor\VendorDestroyJob;
use App\Jobs\Api\Vendor\VendorIndexJob;
use App\Jobs\Api\Vendor\VendorStoreJob;
use App\Jobs\Api\Vendor\VendorUpdateJob;
use App\Models\ApiModel;

class ApiJobFactory
{

    /**
     * @param $resourceIdentifier
     * @param $data
     * @param null $query
     * @return mixed
     * @throws NotImplementedException
     */
    public static function index($resourceIdentifier, $data, $query = null)
    {
        switch ($resourceIdentifier) {
            case 'countries':
                return CountryIndexJob::dispatchNow($data, $query);
            case 'states':
                return StateIndexJob::dispatchNow($data, $query);
            case 'cities':
                return CityIndexJob::dispatchNow($data, $query);
            case 'regions':
                return RegionIndexJob::dispatchNow($data, $query);
            case 'people':
                return PersonIndexJob::dispatchNow($data, $query);
            case 'vendors':
                return VendorIndexJob::dispatchNow($data, $query);
            case 'tags':
                return TagIndexJob::dispatchNow($data, $query);
            case 'media_objects':
                return MediaObjectIndexJob::dispatchNow($data, $query);
            default:
                throw new NotImplementedException("IndexJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }
    }

    /**
     * @param $resourceIdentifier
     * @param array $request_data
     * @return ApiModel
     * @throws NotImplementedException
     */
    public static function store($resourceIdentifier, array $request_data)
    {

        switch ($resourceIdentifier) {
            case 'countries':
            case 'country':
                return CountryStoreJob::dispatchNow($request_data);
            case 'states':
            case 'state':
                return StateStoreJob::dispatchNow($request_data);
            case 'city':
            case 'cities':
                return CityStoreJob::dispatchNow($request_data);
            case 'region':
            case 'regions':
                return RegionStoreJob::dispatchNow($request_data);
            case 'people':
            case 'person':
                return PersonStoreJob::dispatchNow($request_data);
            case 'vendors':
            case 'vendor':
                return VendorStoreJob::dispatchNow($request_data);
            case 'tags':
            case 'tag':
                return TagStoreJob::dispatchNow($request_data);
            case 'media_objects':
            case 'media_object':
                return MediaObjectStoreJob::dispatchNow($request_data);
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
            case 'cities':
                return CityUpdateJob::class;
            case 'regions':
                return RegionUpdateJob::class;
            case 'people':
                return PersonUpdateJob::class;
            case 'vendors':
                return VendorUpdateJob::class;
            case 'tags':
                return TagUpdateJob::class;
            case 'media_objects':
                return MediaObjectUpdateJob::class;
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
            case 'cities':
                return CityDestroyJob::class;
            case 'regions':
                return RegionDestroyJob::class;
            case 'people':
                return PersonDestroyJob::class;
            case 'vendors':
                return VendorDestroyJob::class;
            case 'tags':
                return TagDestroyJob::class;
            case 'media_objects':
                return MediaObjectDestroyJob::class;
            default:
                throw new NotImplementedException("DestroyJob for '$resourceIdentifier' is not defined in ApiJobFactory");
        }

    }

}
