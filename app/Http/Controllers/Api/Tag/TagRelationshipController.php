<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\ApiController;
use App\Jobs\Relationship\RelationshipDestroyJob;
use App\Jobs\Relationship\RelationshipIndexJob;
use App\Jobs\Relationship\RelationshipStoreJob;
use App\Jobs\Relationship\RelationshipUpdateJob;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagRelationshipController extends ApiController
{

    public function index(Request $request, Tag $tag, $relationship)
    {
        $relationships = RelationshipIndexJob::dispatchNow($tag, $relationship);
        return $relationships;
    }

    public function store(Request $request, Tag $tag, $relationship)
    {
        $response = RelationshipStoreJob::dispatchNow($tag, $relationship, $request->all());
        return $this->response($response);
    }

    public function update(Request $request, Tag $tag, $relationship)
    {
        $response = RelationshipUpdateJob::dispatchNow($tag, $relationship, $request->all());
        return $this->response($response);
    }

    public function destroy(Request $request, Tag $tag, $relationship)
    {
        $response = RelationshipDestroyJob::dispatchNow($tag, $relationship, $request->all());
        return $this->response($response);
    }

}
