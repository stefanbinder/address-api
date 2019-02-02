<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Country\CountryIndexRequest;
use App\Jobs\Api\RelationshipIndexJob;
use App\Models\Address\Country;
use Illuminate\Support\Facades\Request;

class CountryRelationshipController extends ApiController
{

    /**
     * @param Request $request
     * @param Country $country
     * @param $relationship
     * @return mixed
     * @throws \Exception
     */
    public function index(CountryIndexRequest $request, Country $country, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($country, $relationship);
        return $relationships;
    }

}
