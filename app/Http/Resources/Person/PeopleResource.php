<?php

namespace App\Http\Resources\Person;

use App\Models\User\Person;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PeopleResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function(Person $person) {
            return new PersonResource($person);
        });
        return parent::toArray($request);
    }
}
