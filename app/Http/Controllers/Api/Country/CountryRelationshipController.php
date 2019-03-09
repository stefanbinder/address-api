<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Jobs\Api\RelationshipDestroyJob;
use App\Jobs\Api\RelationshipIndexJob;
use App\Jobs\Api\RelationshipStoreJob;
use App\Jobs\Api\RelationshipUpdateJob;
use App\Models\Address\Country;
use Illuminate\Http\Request;

class CountryRelationshipController extends ApiController
{

    /**
     * @param Request $request
     * @param Country $country
     * @param $relationship
     * @return mixed
     */
    public function index(Request $request, Country $country, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($country, $relationship);
        return $relationships;
    }

    public function store(Request $request, Country $country, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($country, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, Country $country, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($country, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, Country $country, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($country, $relationship, $request->all());
        return $this->response($response);
    }

}
