<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Media\MediaDestroyRequest;
use App\Http\Requests\Api\Media\MediaIndexRequest;
use App\Http\Requests\Api\Media\MediaShowRequest;
use App\Http\Requests\Api\Media\MediaStoreRequest;
use App\Http\Requests\Api\Media\MediaUpdateRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Api\Media\MediaDestroyJob;
use App\Jobs\Api\Media\MediaIndexJob;
use App\Jobs\Api\Media\MediaStoreJob;
use App\Jobs\Api\Media\MediaUpdateJob;
use App\Models\Media\Media;

class MediaController extends ApiController
{

    public function index(MediaIndexRequest $request)
    {
        $media = MediaIndexJob::dispatchNow($request->all());
        $resource  = ApiResourceFactory::resourceCollection("media", $media);
        return $this->response($resource);
    }

    public function show(MediaShowRequest $request, Media $media)
    {
        $resource = ApiResourceFactory::resourceObject("media", $media);
        return $this->response($resource);
    }

    public function store(MediaStoreRequest $request)
    {
        $data     = $request->validated();
        $media  = MediaStoreJob::dispatchNow($data);
        $resource = ApiResourceFactory::resourceObject("media", $media);
        return $this->response($resource);
    }

    public function update(MediaUpdateRequest $request, Media $media)
    {
        $data     = $request->validated();
        $media  = MediaUpdateJob::dispatchNow($media, $data);
        $resource = ApiResourceFactory::resourceObject("media", $media);
        return $this->response($resource);
    }

    public function destroy(MediaDestroyRequest $request, $media)
    {
        $media = Media::withTrashed()->find($media);
        $media = MediaDestroyJob::dispatchNow($media);
        return $this->response($media);
    }

}
