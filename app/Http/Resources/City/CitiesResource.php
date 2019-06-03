<?php

namespace App\Http\Resources\City;

use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Address\City;

class CitiesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (City $city) {
            return new CityResource($city, ResourceObject::DEFAULT_INDEX_EMBEDS);
        });

        return parent::toArray($request);
    }

}
