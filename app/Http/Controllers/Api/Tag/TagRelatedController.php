<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Tag\TagIndexRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Related\RelatedDestroyJob;
use App\Jobs\Related\RelatedShowJob;
use App\Jobs\Related\RelatedStoreJob;
use App\Jobs\Related\RelatedUpdateJob;
use App\Jobs\Related\RelatedIndexJob;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagRelatedController extends ApiController
{

    public function index(TagIndexRequest $request, Tag $tag, $related)
    {
        // RelatedIndexJob already sends Resource back (single or collection) depending on relationship
        $resource = RelatedIndexJob::dispatchNow($request->all(), $tag, $related);
        return $this->response($resource);
    }

    public function show(Request $request, Tag $tag, $related, $id)
    {
        $relative = RelatedShowJob::dispatchNow($request->all(), $tag, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function store(Request $request, Tag $tag, $related)
    {
        $relative = RelatedStoreJob::dispatchNow($request->all(), $tag, $related);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function update(Request $request, Tag $tag, $related, $id)
    {
        $relative = RelatedUpdateJob::dispatchNow($request->all(), $tag, $related, $id);
        $resource = ApiResourceFactory::resourceObject($relative::ID, $relative);
        return $this->response($resource);
    }

    public function destroy(Request $request, Tag $tag, $related, $id)
    {
        $tag = RelatedDestroyJob::dispatchNow($tag, $related, $id);
        return $this->response($tag);
    }

}
