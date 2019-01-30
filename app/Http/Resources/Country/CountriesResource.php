<?php

namespace App\Http\Resources\Country;

use App\Models\Address\Country;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CountriesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function(Country $country) {
            return new CountryResource($country);
        });
        return parent::toArray($request);
    }
}
