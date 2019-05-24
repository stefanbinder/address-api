<?php

namespace App\Http\Controllers\Api\MediaObject;

use App\Http\Controllers\ApiController;
use App\Jobs\Relationship\RelationshipDestroyJob;
use App\Jobs\Relationship\RelationshipIndexJob;
use App\Jobs\Relationship\RelationshipStoreJob;
use App\Jobs\Relationship\RelationshipUpdateJob;
use App\Models\MediaObject\MediaObject;
use Illuminate\Http\Request;

class MediaObjectRelationshipController extends ApiController
{

    public function index(Request $request, MediaObject $media_object, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($media_object, $relationship);
        return $relationships;
    }

    public function store(Request $request, MediaObject $media_object, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($media_object, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, MediaObject $media_object, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($media_object, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, MediaObject $media_object, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($media_object, $relationship, $request->all());
        return $this->response($response);
    }

}
