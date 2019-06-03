<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\ApiController;
use App\Jobs\Relationship\RelationshipDestroyJob;
use App\Jobs\Relationship\RelationshipIndexJob;
use App\Jobs\Relationship\RelationshipStoreJob;
use App\Jobs\Relationship\RelationshipUpdateJob;
use App\Models\Address\Region;
use Illuminate\Http\Request;

class RegionRelationshipController extends ApiController
{

    public function index(Request $request, Region $region, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($region, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, Region $region, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($region, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, Region $region, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($region, $relationship, $request->all());
        return $this->response($response);
    }

}
