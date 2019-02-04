<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Http\Resources\ResourceFactory;
use App\Jobs\Api\Country\CountryRelatedIndexJob;
use App\Jobs\Api\Country\CountryRelatedShowJob;
use App\Jobs\Api\Country\CountryRelatedStoreJob;
use App\Models\Address\Country;
use Illuminate\Http\Request;

class CountryRelatedController extends ApiController
{

    /**
     * @param CountryIndexRequest $request
     * @param Country $country
     * @param $related
     * @return mixed
     * @throws \Exception
     */
    public function index(CountryIndexRequest $request, Country $country, $related)
    {
        $relatives = CountryRelatedIndexJob::dispatchNow($request->all(), $country, $related);
        $resource = ResourceFactory::resource($related, $relatives);
        return $this->response($resource);
    }

    public function show(Request $request, Country $country, $related, $id)
    {
        $relative = CountryRelatedShowJob::dispatchNow($request->all(), $country, $related, $id);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, Country $country, $related)
    {
        $relative = CountryRelatedStoreJob::dispatchNow($request->all(), $country, $related);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, Country $country, $related, $id)
    {

        $relative = CountryRelatedUpdateJob::dispatchNow($request->all(), $country, $related);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }


}
