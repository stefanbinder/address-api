<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Http\Requests\Api\State\StateStoreRequest;
use App\Http\Resources\ResourceFactory;
use App\Jobs\Api\Country\CountryRelatedIndexJob;
use App\Jobs\Api\Country\CountryRelatedShowJob;
use App\Models\Address\Country;
use App\Models\ApiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    public function store(RelatedStoreRequest $request, Country $country, $related)
    {
        $data = $request->validated();
        dd($data);

        $country = CountryStoreJob::dispatchNow($data);
        $resource = new CountryResource($country);
        return $this->response($resource);
    }


}
