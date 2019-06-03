<?php

namespace App\Http\Resources\City;

use App\Http\Resources\ResourceObject;
use App\Jobs\Related\RelatedIndexJob;
use App\Models\Address\City;
use App\Models\Address\Country;

class CityResource extends ResourceObject
{

    public function get_model()
    {
        return City::class;
    }

    protected function get_default_fields()
    {
        return $this->get_all_fields();
    }

    protected function get_all_fields()
    {
        return [
            'name',
            'type',
            'created_at',
            'updated_at',
        ];
    }

    protected function get_relationships()
    {
        return [
            'country',
            'state',
        ];
    }

    protected function get_relationship($relationship, $request_data)
    {
        return RelatedIndexJob::dispatchNow($request_data, $this->resource, $relationship);
    }

    public function name()
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }

    public function created_at()
    {
        return (string)$this->created_at;
    }

    public function updated_at()
    {
        return (string)$this->updated_at;
    }

}
