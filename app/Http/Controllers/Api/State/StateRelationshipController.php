<?php

namespace App\Http\Controllers\Api\State;


use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\State\StateIndexRequest;
use App\Jobs\Api\RelationshipIndexJob;
use App\Models\Address\State;

class StateRelationshipController extends ApiController
{

    /**
     * @param StateIndexRequest $request
     * @param State $state
     * @param $relationship
     * @return mixed
     */
    public function index(StateIndexRequest $request, State $state, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($state, $relationship);
        return $relationships;
    }

}
