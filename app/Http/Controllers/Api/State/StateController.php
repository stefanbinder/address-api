<?php

namespace App\Http\Controllers\Api\State;


use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\State\StateIndexRequest;
use App\Http\Requests\Api\State\StateShowRequest;
use App\Http\Resources\State\StatesResource;
use App\Http\Resources\State\StateResource;
use App\Jobs\Api\State\StateIndexJob;
use App\Models\Address\State;

class StateController extends ApiController
{

    public function index(StateIndexRequest $request)
    {
        $countries = StateIndexJob::dispatchNow($request->all());
        $resource = new StatesResource($countries);

        return $this->response($resource);
    }

    public function show(StateShowRequest $request, State $state)
    {
        $resource = new StateResource($state);
        return $this->response($resource);
    }

//    public function store(StateStoreRequest $request)
//    {
//        $data    = $request->validated();
//        $state = StateStoreCommand::create($data);
//        $resource = new StateResource($state);
//        return $this->response($resource);
//
////        $state = State::create($data['data']['attributes']);
//    }
//
//    public function update(StateUpdateRequest $request, State $state)
//    {
//        $data = $request->validated();
//        $state = StateUpdateCommand::update($data);
////        $state->update($data['data']['attributes']);
//        return new StateResource($state);
//    }
//
//    public function destroy(StateDestroyRequest $request, State $state)
//    {
//        $state = StateUpdateCommand::destroy($state);
//        return true;
//
//    }

}
