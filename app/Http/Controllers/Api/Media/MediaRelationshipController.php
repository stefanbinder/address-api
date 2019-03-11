<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\ApiController;
use App\Jobs\Api\RelationshipDestroyJob;
use App\Jobs\Api\RelationshipIndexJob;
use App\Jobs\Api\RelationshipStoreJob;
use App\Jobs\Api\RelationshipUpdateJob;
use App\Models\Media\Media;
use Illuminate\Http\Request;

class MediaRelationshipController extends ApiController
{

    public function index(Request $request, Media $media, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($media, $relationship);
        return $relationships;
    }

    public function store(Request $request, Media $media, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($media, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, Media $media, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($media, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, Media $media, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($media, $relationship, $request->all());
        return $this->response($response);
    }

}
