<?php

namespace App\Http\Controllers\Api\State;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\State\StateDestroyRequest;
use App\Http\Requests\Api\State\StateIndexRequest;
use App\Http\Requests\Api\State\StateShowRequest;
use App\Http\Requests\Api\State\StateStoreRequest;
use App\Http\Requests\Api\State\StateUpdateRequest;
use App\Http\Resources\ResourceFactory;
use App\Http\Resources\State\StatesResource;
use App\Http\Resources\State\StateResource;
use App\Jobs\Api\State\StateDestroyJob;
use App\Jobs\Api\State\StateIndexJob;
use App\Jobs\Api\State\StateStoreJob;
use App\Jobs\Api\State\StateUpdateJob;
use App\Models\Address\State;

class StateController extends ApiController
{

    public function index(StateIndexRequest $request)
    {
        $states   = StateIndexJob::dispatchNow($request->all());
        $resource = ResourceFactory::resourceCollection("states", $states);

        return $this->response($resource);
    }

    public function show(StateShowRequest $request, State $state)
    {
        $resource = ResourceFactory::resourceObject("state", $state);
        return $this->response($resource);
    }

    public function store(StateStoreRequest $request)
    {
        $data     = $request->validated();
        $state    = StateStoreJob::dispatchNow($data);
        $resource = ResourceFactory::resourceObject("state", $state);

        return $this->response($resource);
    }

    public function update(StateUpdateRequest $request, State $state)
    {
        $data     = $request->validated();
        $state    = StateUpdateJob::dispatchNow($state, $data);
        $resource = ResourceFactory::resourceObject("state", $state);

        return $this->response($resource);
    }

    public function destroy(StateDestroyRequest $request, State $state)
    {
        $state = StateDestroyJob::dispatchNow($state);
        return $this->response($state);
    }

}
