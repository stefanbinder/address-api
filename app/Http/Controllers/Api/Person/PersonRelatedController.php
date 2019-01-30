<?php

namespace App\Http\Controllers\Api\Person;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Person\PersonIndexRequest;
use App\Jobs\Api\Person\PersonRelatedIndexJob;
use App\Models\User\Person;

class PersonRelatedController extends ApiController
{

    /**
     * @param PersonIndexRequest $request
     * @param Person $person
     * @param $related
     * @return mixed
     */
    public function index(PersonIndexRequest $request, Person $person, $related)
    {
        $relatives = PersonRelatedIndexJob::dispatchNow($person, $related);
        return $relatives;
    }

}
