<?php

namespace App\Http\Controllers\Api\State;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\State\StateIndexRequest;
use App\Jobs\Api\State\StateRelatedIndexJob;
use App\Models\Address\State;

class StateRelatedController extends ApiController
{

    /**
     * @param StateIndexRequest $request
     * @param State $state
     * @param $related
     * @return mixed
     */
    public function index(StateIndexRequest $request, State $state, $related)
    {
        $relatives = StateRelatedIndexJob::dispatchNow($request->all(), $state, $related);
        return $relatives;
    }

}
