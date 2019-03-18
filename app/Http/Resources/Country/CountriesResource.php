<?php

namespace App\Http\Resources\Country;

use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Address\Country;

class CountriesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Country $country) {
            return new CountryResource($country, ResourceObject::DEFAULT_INDEX_EMBEDS);
        });

        return parent::toArray($request);
    }

}
