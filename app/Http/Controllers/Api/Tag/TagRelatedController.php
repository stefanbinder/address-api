<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Tag\TagIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Api\Tag\TagRelatedDestroyJob;
use App\Jobs\Api\Tag\TagRelatedIndexJob;
use App\Jobs\Api\Tag\TagRelatedShowJob;
use App\Jobs\Api\Tag\TagRelatedStoreJob;
use App\Jobs\Api\Tag\TagRelatedUpdateJob;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagRelatedController extends ApiController
{

    public function index(TagIndexRequest $request, Tag $tag, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = TagRelatedIndexJob::dispatchNow($request->all(), $tag, $related);
        return $this->response($resource);
    }

    public function show(Request $request, Tag $tag, $related, $id)
    {
        $relative = TagRelatedShowJob::dispatchNow($request->all(), $tag, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, Tag $tag, $related)
    {
        $relative = TagRelatedStoreJob::dispatchNow($request->all(), $tag, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, Tag $tag, $related, $id)
    {
        $relative = TagRelatedUpdateJob::dispatchNow($request->all(), $tag, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, Tag $tag, $related, $id)
    {
        $tag = TagRelatedDestroyJob::dispatchNow($tag, $related, $id);
        return $this->response($tag);
    }

}
