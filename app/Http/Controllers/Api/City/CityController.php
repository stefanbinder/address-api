<?php

namespace App\Http\Controllers\Api\City;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\City\CityDestroyRequest;
use App\Http\Requests\Api\City\CityIndexRequest;
use App\Http\Requests\Api\City\CityShowRequest;
use App\Http\Requests\Api\City\CityStoreRequest;
use App\Http\Requests\Api\City\CityUpdateRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Api\ApiJobFactory;
use App\Jobs\Api\City\CityDestroyJob;
use App\Jobs\Api\City\CityUpdateJob;
use App\Models\Address\City;

class CityController extends ApiController
{

    public function index(CityIndexRequest $request)
    {
        $cities = ApiJobFactory::index("cities", $request->all());
        $resource  = ApiResourceFactory::resourceCollection("cities", $cities);
        return $this->response($resource);
    }

    public function show(CityShowRequest $request, City $city)
    {
        $resource = ApiResourceFactory::resourceObject("city", $city);
        return $this->response($resource);
    }

    public function store(CityStoreRequest $request)
    {
        $data     = $request->validated();
        $city  = ApiJobFactory::store("city", $data);
        $resource = ApiResourceFactory::resourceObject("city", $city);
        return $this->response($resource);
    }

    public function update(CityUpdateRequest $request, City $city)
    {
        $data     = $request->validated();
        $city  = CityUpdateJob::dispatchNow($city, $data);
        $resource = ApiResourceFactory::resourceObject("city", $city);
        return $this->response($resource);
    }

    public function destroy(CityDestroyRequest $request, $city)
    {
        $city = City::withTrashed()->find($city);
        $city = CityDestroyJob::dispatchNow($city);
        return $this->response($city);
    }

}
