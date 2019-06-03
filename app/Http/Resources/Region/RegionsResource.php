<?php

namespace App\Http\Resources\Region;

use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Address\Region;

class RegionsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Region $region) {
            return new RegionResource($region, ResourceObject::DEFAULT_INDEX_EMBEDS);
        });

        return parent::toArray($request);
    }

}
