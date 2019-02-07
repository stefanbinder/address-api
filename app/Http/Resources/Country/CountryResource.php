<?php

namespace App\Http\Resources\Country;

use App\Http\Resources\ResourceObject;
use App\Jobs\Api\Country\CountryRelatedIndexJob;
use App\Models\Address\Country;

class CountryResource extends ResourceObject
{

    protected function get_model()
    {
        return Country::class;
    }

    protected function get_default_fields()
    {
        return $this->get_all_fields();
    }

    protected function get_all_fields()
    {
        return [
            'name',
            'code',
            'inhabitants',
            'founded_at',
            'last_visited',
            'created_at',
            'updated_at',
        ];
    }

    protected function get_relationships()
    {
        return [
            'states',
            'president'
        ];
    }

    protected function get_relationship($relationship, $request_data)
    {
        return CountryRelatedIndexJob::dispatchNow($request_data, $this->resource, $relationship);
    }

    public function name()
    {
        return $this->name;
    }

    public function code()
    {
        return $this->code;
    }

    public function code2()
    {
        return $this->code2;
    }

    public function code3()
    {
        return $this->code3;
    }

    public function inhabitants()
    {
        return $this->inhabitants;
    }

    public function founded_at()
    {
        return $this->founded_at;
    }

    public function last_visited()
    {
        return $this->last_visited;
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
