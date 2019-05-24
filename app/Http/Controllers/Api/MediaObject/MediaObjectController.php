<?php

namespace App\Http\Controllers\Api\MediaObject;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\MediaObject\MediaObjectDestroyRequest;
use App\Http\Requests\Api\MediaObject\MediaObjectIndexRequest;
use App\Http\Requests\Api\MediaObject\MediaObjectShowRequest;
use App\Http\Requests\Api\MediaObject\MediaObjectStoreRequest;
use App\Http\Requests\Api\MediaObject\MediaObjectUpdateRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Api\MediaObject\MediaObjectDestroyJob;
use App\Jobs\Api\MediaObject\MediaObjectIndexJob;
use App\Jobs\Api\MediaObject\MediaObjectStoreJob;
use App\Jobs\Api\MediaObject\MediaObjectUpdateJob;
use App\Models\MediaObject\MediaObject;

class MediaObjectController extends ApiController
{

    public function index(MediaObjectIndexRequest $request)
    {
        $media_object = MediaObjectIndexJob::dispatchNow($request->all());
        $resource    = ApiResourceFactory::resourceCollection("media_objects", $media_object);
        return $this->response($resource);
    }

    public function show(MediaObjectShowRequest $request, MediaObject $media_object)
    {
        $resource = ApiResourceFactory::resourceObject("media_object", $media_object);
        return $this->response($resource);
    }

    public function store(MediaObjectStoreRequest $request)
    {
        $data        = $request->validated();
        $media_object = MediaObjectStoreJob::dispatchNow($data);
        $resource    = ApiResourceFactory::resourceObject("media_object", $media_object);
        return $this->response($resource);
    }

    public function update(MediaObjectUpdateRequest $request, MediaObject $media_object)
    {
        $data        = $request->validated();
        $media_object = MediaObjectUpdateJob::dispatchNow($media_object, $data);
        $resource    = ApiResourceFactory::resourceObject("media_object", $media_object);
        return $this->response($resource);
    }

    public function destroy(MediaObjectDestroyRequest $request, $media_object)
    {
        $media_object = MediaObject::withTrashed()->find($media_object);
        $media_object = MediaObjectDestroyJob::dispatchNow($media_object);
        return $this->response($media_object);
    }

}
