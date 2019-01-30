<?php

namespace App\Http\Controllers\Api\Person;


use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Http\Requests\Api\Person\PersonIndexRequest;
use App\Jobs\Api\RelationshipIndexJob;
use App\Models\Address\Country;
use App\Models\User\Person;
use Illuminate\Support\Facades\Request;

class PersonRelationshipController extends ApiController
{

    /**
     * @param PersonIndexRequest $request
     * @param Person $person
     * @param $relationship
     * @return mixed
     */
    public function index(PersonIndexRequest $request, Person $person, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($person, $relationship);
        return $relationships;
    }

}
