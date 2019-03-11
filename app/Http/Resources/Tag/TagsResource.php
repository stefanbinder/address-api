<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\ResourceObject;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Tag $tag) {
            return new TagResource($tag, ResourceObject::DEFAULT_INDEX_EMBEDS);
        });
        return parent::toArray($request);
    }
}
