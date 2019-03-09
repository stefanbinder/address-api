<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Http\Requests\Api\Relationship\RelationshipStoreRequest;
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
     * @throws \Exception
     */
    public function index(CountryIndexRequest $request, Country $country, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($country, $relationship);
        return $relationships;
    }

    public function store(RelationshipStoreRequest $request, Country $country, $relationship)
    {
        $resourceData = $request->validated();
        $response     = RelationshipStoreJob::dispatchNow($country, $relationship, $resourceData);
        return $this->response($response);
    }

    public function update(Request $request, Country $country, $relationship)
    {
        $resourceData = $request->all();
        $response = RelationshipUpdateJob::dispatchNow($country, $relationship, $resourceData);
        return $this->response($response);
    }

    public function destroy(Request $request, Country $country, $relationship)
    {
        $resourceData = $request->all();
        $response = RelationshipDestroyJob::dispatchNow($country, $relationship, $resourceData);
        return $this->response($response);
    }

}
