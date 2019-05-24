<?php

namespace App\Http\Controllers\Api\State;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\State\StateIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Related\RelatedDestroyJob;
use App\Jobs\Related\RelatedShowJob;
use App\Jobs\Related\RelatedUpdateJob;
use App\Jobs\Related\RelatedIndexJob;
use App\Jobs\Related\RelatedStoreJob;
use App\Models\Address\State;
use Illuminate\Http\Request;

class StateRelatedController extends ApiController
{

    public function index(StateIndexRequest $request, State $state, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = RelatedIndexJob::dispatchNow($request->all(), $state, $related);
        return $this->response($resource);
    }

    public function show(Request $request, State $state, $related, $id)
    {
        $relative = RelatedShowJob::dispatchNow($request->all(), $state, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, State $state, $related)
    {
        $relative = RelatedStoreJob::dispatchNow($request->all(), $state, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, State $state, $related, $id)
    {
        $relative = RelatedUpdateJob::dispatchNow($request->all(), $state, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, State $state, $related, $id)
    {
        $state = RelatedDestroyJob::dispatchNow($state, $related, $id);
        return $this->response($state);
    }

}
