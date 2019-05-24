<?php

namespace App\Http\Controllers\Api\Person;

use App\Http\Controllers\ApiController;
use App\Jobs\Relationship\RelationshipDestroyJob;
use App\Jobs\Relationship\RelationshipIndexJob;
use App\Jobs\Relationship\RelationshipStoreJob;
use App\Jobs\Relationship\RelationshipUpdateJob;
use App\Models\User\Person;
use Illuminate\Http\Request;

class PersonRelationshipController extends ApiController
{

    public function index(Request $request, Person $person, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($person, $relationship);
        return $relationships;
    }

    public function store(Request $request, Person $person, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($person, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, Person $person, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($person, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, Person $person, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($person, $relationship, $request->all());
        return $this->response($response);
    }

}
