<?php

namespace App\Http\Resources\Media;

use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Media\Media;

class MediasResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Media $media) {
            return new MediaResource($media, ResourceObject::DEFAULT_INDEX_EMBEDS);
        });
        return parent::toArray($request);
    }
}
