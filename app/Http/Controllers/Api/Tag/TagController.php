<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Tag\TagDestroyRequest;
use App\Http\Requests\Api\Tag\TagIndexRequest;
use App\Http\Requests\Api\Tag\TagShowRequest;
use App\Http\Requests\Api\Tag\TagStoreRequest;
use App\Http\Requests\Api\Tag\TagUpdateRequest;
use App\Http\Resources\ApiResourceFactory;
use App\Jobs\Api\Tag\TagDestroyJob;
use App\Jobs\Api\Tag\TagIndexJob;
use App\Jobs\Api\Tag\TagStoreJob;
use App\Jobs\Api\Tag\TagUpdateJob;
use App\Models\Tag;

class TagController extends ApiController
{

    public function index(TagIndexRequest $request)
    {
        $tags = TagIndexJob::dispatchNow($request->all());
        $resource  = ApiResourceFactory::resourceCollection("tags", $tags);
        return $this->response($resource);
    }

    public function show(TagShowRequest $request, Tag $tag)
    {
        $resource = ApiResourceFactory::resourceObject("tag", $tag);
        return $this->response($resource);
    }

    public function store(TagStoreRequest $request)
    {
        $data     = $request->validated();
        $tag  = TagStoreJob::dispatchNow($data);
        $resource = ApiResourceFactory::resourceObject("tag", $tag);
        return $this->response($resource);
    }

    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $data     = $request->validated();
        $tag  = TagUpdateJob::dispatchNow($tag, $data);
        $resource = ApiResourceFactory::resourceObject("tag", $tag);
        return $this->response($resource);
    }

    public function destroy(TagDestroyRequest $request, $tag)
    {
        $tag = Tag::withTrashed()->find($tag);
        $tag = TagDestroyJob::dispatchNow($tag);
        return $this->response($tag);
    }

}
