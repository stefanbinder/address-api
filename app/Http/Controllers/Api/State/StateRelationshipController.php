<?php

namespace App\Http\Controllers\Api\State;

use App\Http\Controllers\ApiController;
use App\Jobs\Api\RelationshipDestroyJob;
use App\Jobs\Api\RelationshipIndexJob;
use App\Jobs\Api\RelationshipStoreJob;
use App\Jobs\Api\RelationshipUpdateJob;
use App\Models\Address\State;
use Illuminate\Http\Request;

class StateRelationshipController extends ApiController
{

    public function index(Request $request, State $state, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($state, $relationship);
        return $relationships;
    }

    public function store(Request $request, State $state, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($state, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, State $state, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($state, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, State $state, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($state, $relationship, $request->all());
        return $this->response($response);
    }

}
