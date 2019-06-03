<?php

namespace App\Http\Controllers\Api\City;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\City\CityIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Related\RelatedDestroyJob;
use App\Jobs\Related\RelatedShowJob;
use App\Jobs\Related\RelatedUpdateJob;
use App\Jobs\Related\RelatedIndexJob;
use App\Jobs\Related\RelatedStoreJob;
use App\Models\Address\City;
use Illuminate\Http\Request;

class CityRelatedController extends ApiController
{

    public function index(CityIndexRequest $request, City $city, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = RelatedIndexJob::dispatchNow($request->all(), $city, $related);
        return $this->response($resource);
    }

    public function show(Request $request, City $city, $related, $id)
    {
        $relative = RelatedShowJob::dispatchNow($request->all(), $city, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, City $city, $related)
    {
        $relative = RelatedStoreJob::dispatchNow($request->all(), $city, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, City $city, $related, $id)
    {
        $relative = RelatedUpdateJob::dispatchNow($request->all(), $city, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, City $city, $related, $id)
    {
        $city = RelatedDestroyJob::dispatchNow($city, $related, $id);
        return $this->response($city);
    }

}
