<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Region\RegionDestroyRequest;
use App\Http\Requests\Api\Region\RegionIndexRequest;
use App\Http\Requests\Api\Region\RegionShowRequest;
use App\Http\Requests\Api\Region\RegionStoreRequest;
use App\Http\Requests\Api\Region\RegionUpdateRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Api\ApiJobFactory;
use App\Jobs\Api\Region\RegionDestroyJob;
use App\Jobs\Api\Region\RegionUpdateJob;
use App\Models\Address\Region;

class RegionController extends ApiController
{

    public function index(RegionIndexRequest $request)
    {
        $regions = ApiJobFactory::index("regions", $request->all());
        $resource  = ApiResourceFactory::resourceCollection("regions", $regions);
        return $this->response($resource);
    }

    public function show(RegionShowRequest $request, Region $region)
    {
        $resource = ApiResourceFactory::resourceObject("region", $region);
        return $this->response($resource);
    }

    public function store(RegionStoreRequest $request)
    {
        $data     = $request->validated();
        $region  = ApiJobFactory::store("region", $data);
        $resource = ApiResourceFactory::resourceObject("region", $region);
        return $this->response($resource);
    }

    public function update(RegionUpdateRequest $request, Region $region)
    {
        $data     = $request->validated();
        $region  = RegionUpdateJob::dispatchNow($region, $data);
        $resource = ApiResourceFactory::resourceObject("region", $region);
        return $this->response($resource);
    }

    public function destroy(RegionDestroyRequest $request, $region)
    {
        $region = Region::withTrashed()->find($region);
        $region = RegionDestroyJob::dispatchNow($region);
        return $this->response($region);
    }

}
