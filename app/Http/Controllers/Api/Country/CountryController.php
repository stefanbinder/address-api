<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Http\Requests\Api\Country\CountryShowRequest;
use App\Http\Requests\Api\Country\CountryStoreRequest;
use App\Http\Resources\Country\CountriesResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\ResourceFactory;
use App\Jobs\Api\Country\CountryIndexJob;
use App\Jobs\Api\Country\CountryStoreJob;
use App\Models\Address\Country;

class CountryController extends ApiController
{

    public function index(CountryIndexRequest $request)
    {
        $countries = CountryIndexJob::dispatchNow($request->all());
        $resource  = ResourceFactory::resourceCollection("countries", $countries);

        return $this->response($resource);
    }

    public function show(CountryShowRequest $request, Country $country)
    {
        $resource = ResourceFactory::resourceObject("country", $country);
        return $this->response($resource);
    }

    public function store(CountryStoreRequest $request)
    {
        $data     = $request->validated();
        $country  = CountryStoreJob::dispatchNow($data);
        $resource = ResourceFactory::resourceObject("country", $country);

        return $this->response($resource);
    }
//
//    public function update(CountryUpdateRequest $request, Country $country)
//    {
//        $data = $request->validated();
//        $country = CountryUpdateCommand::update($data);
////        $country->update($data['data']['attributes']);
//        return new CountryResource($country);
//    }
//
//    public function destroy(CountryDestroyRequest $request, Country $country)
//    {
//        $country = CountryUpdateCommand::destroy($country);
//        return true;
//
//    }

}
