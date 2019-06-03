<?php

namespace App\Http\Controllers\Api\City;

use App\Http\Controllers\ApiController;
use App\Jobs\Relationship\RelationshipDestroyJob;
use App\Jobs\Relationship\RelationshipIndexJob;
use App\Jobs\Relationship\RelationshipStoreJob;
use App\Jobs\Relationship\RelationshipUpdateJob;
use App\Models\Address\City;
use Illuminate\Http\Request;

class CityRelationshipController extends ApiController
{

    public function index(Request $request, City $city, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($city, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, City $city, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($city, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, City $city, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($city, $relationship, $request->all());
        return $this->response($response);
    }

}
