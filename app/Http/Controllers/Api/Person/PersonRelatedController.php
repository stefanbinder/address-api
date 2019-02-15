<?php

namespace App\Http\Controllers\Api\Person;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Person\PersonIndexRequest;
use App\Http\Resources\ResourceFactory;
use App\Jobs\Api\Person\PersonRelatedDestroyJob;
use App\Jobs\Api\Person\PersonRelatedIndexJob;
use App\Jobs\Api\Person\PersonRelatedShowJob;
use App\Jobs\Api\Person\PersonRelatedStoreJob;
use App\Jobs\Api\Person\PersonRelatedUpdateJob;
use App\Models\User\Person;
use Illuminate\Http\Request;

class PersonRelatedController extends ApiController
{

    public function index(PersonIndexRequest $request, Person $person, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = PersonRelatedIndexJob::dispatchNow($request->all(), $person, $related);
        return $this->response($resource);
    }

    public function show(Request $request, Person $person, $related, $id)
    {
        $relative = PersonRelatedShowJob::dispatchNow($request->all(), $person, $related, $id);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, Person $person, $related)
    {
        $relative = PersonRelatedStoreJob::dispatchNow($request->all(), $person, $related);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, Person $person, $related, $id)
    {
        $relative = PersonRelatedUpdateJob::dispatchNow($request->all(), $person, $related, $id);
        $resource = ResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, Person $person, $related, $id)
    {
        $person = PersonRelatedDestroyJob::dispatchNow($person, $related, $id);
        return $this->response($person);
    }

}
