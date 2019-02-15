<?php

namespace App\Http\Controllers\Api\State;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\State\StateIndexRequest;
use App\Http\Resources\ResourceFactory;
use App\Jobs\Api\State\StateRelatedDestroyJob;
use App\Jobs\Api\State\StateRelatedIndexJob;
use App\Jobs\Api\State\StateRelatedShowJob;
use App\Jobs\Api\State\StateRelatedStoreJob;
use App\Jobs\Api\State\StateRelatedUpdateJob;
use App\Models\Address\State;
use Illuminate\Http\Request;

class StateRelatedController extends ApiController
{

    public function index(StateIndexRequest $request, State $state, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = StateRelatedIndexJob::dispatchNow($request->all(), $state, $related);
        return $this->response($resource);
    }

    public function show(Request $request, State $state, $related, $id)
    {
        $relative = StateRelatedShowJob::dispatchNow($request->all(), $state, $related, $id);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, State $state, $related)
    {
        $relative = StateRelatedStoreJob::dispatchNow($request->all(), $state, $related);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, State $state, $related, $id)
    {
        $relative = StateRelatedUpdateJob::dispatchNow($request->all(), $state, $related, $id);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, State $state, $related, $id)
    {
        $state = StateRelatedDestroyJob::dispatchNow($state, $related, $id);
        return $this->response($state);
    }

}
