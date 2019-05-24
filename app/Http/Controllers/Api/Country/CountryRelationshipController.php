<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Jobs\Relationship\RelationshipDestroyJob;
use App\Jobs\Relationship\RelationshipIndexJob;
use App\Jobs\Relationship\RelationshipStoreJob;
use App\Jobs\Relationship\RelationshipUpdateJob;
use App\Models\Address\Country;
use Illuminate\Http\Request;

class CountryRelationshipController extends ApiController
{

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
