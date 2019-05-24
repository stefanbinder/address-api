<?php

namespace App\Http\Controllers\Api\MediaObject;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\MediaObject\MediaObjectIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Related\RelatedDestroyJob;
use App\Jobs\Related\RelatedShowJob;
use App\Jobs\Related\RelatedUpdateJob;
use App\Jobs\Related\RelatedIndexJob;
use App\Jobs\Related\RelatedStoreJob;
use App\Models\MediaObject\MediaObject;
use Illuminate\Http\Request;

class MediaObjectRelatedController extends ApiController
{

    public function index(MediaObjectIndexRequest $request, MediaObject $media_object, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = RelatedIndexJob::dispatchNow($request->all(), $media_object, $related);
        return $this->response($resource);
    }

    public function show(Request $request, MediaObject $media_object, $related, $id)
    {
        $relative = RelatedShowJob::dispatchNow($request->all(), $media_object, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, MediaObject $media_object, $related)
    {
        $relative = RelatedStoreJob::dispatchNow($request->all(), $media_object, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, MediaObject $media_object, $related, $id)
    {
        $relative = RelatedUpdateJob::dispatchNow($request->all(), $media_object, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, MediaObject $media_object, $related, $id)
    {
        $media_object = RelatedDestroyJob::dispatchNow($media_object, $related, $id);
        return $this->response($media_object);
    }

}
