<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Region\RegionIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Related\RelatedDestroyJob;
use App\Jobs\Related\RelatedShowJob;
use App\Jobs\Related\RelatedUpdateJob;
use App\Jobs\Related\RelatedIndexJob;
use App\Jobs\Related\RelatedStoreJob;
use App\Models\Address\Region;
use Illuminate\Http\Request;

class RegionRelatedController extends ApiController
{

    public function index(RegionIndexRequest $request, Region $region, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = RelatedIndexJob::dispatchNow($request->all(), $region, $related);
        return $this->response($resource);
    }

    public function show(Request $request, Region $region, $related, $id)
    {
        $relative = RelatedShowJob::dispatchNow($request->all(), $region, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, Region $region, $related)
    {
        $relative = RelatedStoreJob::dispatchNow($request->all(), $region, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, Region $region, $related, $id)
    {
        $relative = RelatedUpdateJob::dispatchNow($request->all(), $region, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, Region $region, $related, $id)
    {
        $region = RelatedDestroyJob::dispatchNow($region, $related, $id);
        return $this->response($region);
    }

}
