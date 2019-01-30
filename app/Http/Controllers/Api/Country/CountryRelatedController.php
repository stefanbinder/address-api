<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Jobs\Api\Country\CountryRelatedIndexJob;
use App\Models\Address\Country;

class CountryRelatedController extends ApiController
{

    /**
     * @param CountryIndexRequest $request
     * @param Country $country
     * @param $related
     * @return mixed
     */
    public function index(CountryIndexRequest $request, Country $country, $related)
    {
        $relatives = CountryRelatedIndexJob::dispatchNow($request->all(), $country, $related);
        return $relatives;
    }

}
