<?php

namespace App\Http\Resources\Person;

use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\User\Person;

class PeopleResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Person $person) {
            return new PersonResource($person, ResourceObject::DEFAULT_INDEX_EMBEDS);
        });
        return parent::toArray($request);
    }
}
