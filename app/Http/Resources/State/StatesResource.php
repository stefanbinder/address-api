<?php

namespace App\Http\Resources\State;

use App\Models\Address\State;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StatesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function(State $state) {
            return new StateResource($state);
        });
        return parent::toArray($request);
    }
}
