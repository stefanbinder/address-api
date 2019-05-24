<?php

namespace App\Http\Controllers\Api\Person;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Person\PersonIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Related\RelatedDestroyJob;
use App\Jobs\Related\RelatedShowJob;
use App\Jobs\Related\RelatedUpdateJob;
use App\Jobs\Related\RelatedIndexJob;
use App\Jobs\Related\RelatedStoreJob;
use App\Models\User\Person;
use Illuminate\Http\Request;

class PersonRelatedController extends ApiController
{

    public function index(PersonIndexRequest $request, Person $person, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = RelatedIndexJob::dispatchNow($request->all(), $person, $related);
        return $this->response($resource);
    }

    public function show(Request $request, Person $person, $related, $id)
    {
        $relative = RelatedShowJob::dispatchNow($request->all(), $person, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, Person $person, $related)
    {
        $relative = RelatedStoreJob::dispatchNow($request->all(), $person, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, Person $person, $related, $id)
    {
        $relative = RelatedUpdateJob::dispatchNow($request->all(), $person, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, Person $person, $related, $id)
    {
        $person = RelatedDestroyJob::dispatchNow($person, $related, $id);
        return $this->response($person);
    }

}
