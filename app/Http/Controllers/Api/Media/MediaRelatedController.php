<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Media\MediaIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Api\Media\MediaRelatedDestroyJob;
use App\Jobs\Api\Media\MediaRelatedIndexJob;
use App\Jobs\Api\Media\MediaRelatedShowJob;
use App\Jobs\Api\Media\MediaRelatedStoreJob;
use App\Jobs\Api\Media\MediaRelatedUpdateJob;
use App\Models\Media\Media;
use Illuminate\Http\Request;

class MediaRelatedController extends ApiController
{

    public function index(MediaIndexRequest $request, Media $media, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = MediaRelatedIndexJob::dispatchNow($request->all(), $media, $related);
        return $this->response($resource);
    }

    public function show(Request $request, Media $media, $related, $id)
    {
        $relative = MediaRelatedShowJob::dispatchNow($request->all(), $media, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, Media $media, $related)
    {
        $relative = MediaRelatedStoreJob::dispatchNow($request->all(), $media, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, Media $media, $related, $id)
    {
        $relative = MediaRelatedUpdateJob::dispatchNow($request->all(), $media, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, Media $media, $related, $id)
    {
        $media = MediaRelatedDestroyJob::dispatchNow($media, $related, $id);
        return $this->response($media);
    }

}
