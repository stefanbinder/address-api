<?php

namespace App\Http\Controllers\Api\Person;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Person\PersonDestroyRequest;
use App\Http\Requests\Api\Person\PersonIndexRequest;
use App\Http\Requests\Api\Person\PersonShowRequest;
use App\Http\Requests\Api\Person\PersonStoreRequest;
use App\Http\Requests\Api\Person\PersonUpdateRequest;
use App\Http\Resources\Person\PeopleResource;
use App\Http\Resources\Person\PersonResource;
use App\Http\Resources\ResourceFactory;
use App\Jobs\Api\Person\PersonDestroyJob;
use App\Jobs\Api\Person\PersonIndexJob;
use App\Jobs\Api\Person\PersonStoreJob;
use App\Jobs\Api\Person\PersonUpdateJob;
use App\Models\User\Person;

class PersonController extends ApiController
{

    public function index(PersonIndexRequest $request)
    {
        $people   = PersonIndexJob::dispatchNow($request->all());
        $resource = ResourceFactory::resourceCollection("people", $people);

        return $this->response($resource);
    }

    public function show(PersonShowRequest $request, Person $person)
    {
        $resource = ResourceFactory::resourceObject("person", $person);
        return $this->response($resource);
    }

    public function store(PersonStoreRequest $request)
    {
        $data     = $request->validated();
        $person   = PersonStoreJob::dispatchNow($data);
        $resource = ResourceFactory::resourceObject("person", $person);

        return $this->response($resource);
    }

    public function update(PersonUpdateRequest $request, Person $person)
    {
        $data     = $request->validated();
        $person   = PersonUpdateJob::dispatchNow($person, $data);
        $resource = ResourceFactory::resourceObject("person", $person);

        return $this->response($resource);
    }

    public function destroy(PersonDestroyRequest $request, Person $person)
    {
        $person = PersonDestroyJob::dispatchNow($person);
        return $this->response($person);
    }

}