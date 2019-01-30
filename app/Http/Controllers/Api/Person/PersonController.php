<?php

namespace App\Http\Controllers\Api\Person;


use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Person\PersonIndexRequest;
use App\Http\Requests\Api\Person\PersonShowRequest;
use App\Http\Resources\Person\PeopleResource;
use App\Http\Resources\Person\PersonResource;
use App\Jobs\Api\Person\PersonIndexJob;
use App\Models\User\Person;

class PersonController extends ApiController
{

    public function index(PersonIndexRequest $request)
    {
        $people = PersonIndexJob::dispatchNow($request->all());
        $resource = new PeopleResource($people);

        return $this->response($resource);
    }

    public function show(PersonShowRequest $request, Person $person)
    {
        $resource = new PersonResource($person);
        return $this->response($resource);
    }
//
//    public function store(PersonStoreRequest $request)
//    {
//        $data    = $request->validated();
//        $person = PersonStoreCommand::create($data);
//        $resource = new PersonResource($person);
//        return $this->response($resource);
//
////        $person = Person::create($data['data']['attributes']);
//    }
//
//    public function update(PersonUpdateRequest $request, Person $person)
//    {
//        $data = $request->validated();
//        $person = PersonUpdateCommand::update($data);
////        $person->update($data['data']['attributes']);
//        return new PersonResource($person);
//    }
//
//    public function destroy(PersonDestroyRequest $request, Person $person)
//    {
//        $person = PersonUpdateCommand::destroy($person);
//        return true;
//
//    }

}
