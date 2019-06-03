<?php

namespace App\Http\Resources\Region;

use App\Http\Resources\ResourceObject;
use App\Jobs\Related\RelatedIndexJob;
use App\Models\Address\Country;
use App\Models\Address\Region;

class RegionResource extends ResourceObject
{

    public function get_model()
    {
        return Region::class;
    }

    protected function get_default_fields()
    {
        return $this->get_all_fields();
    }

    protected function get_all_fields()
    {
        return [
            'name',
            'created_at',
            'updated_at',
        ];
    }

    protected function get_relationships()
    {
        return [
            'subregions',
            'region',
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

    public function created_at()
    {
        return (string)$this->created_at;
    }

    public function updated_at()
    {
        return (string)$this->updated_at;
    }

}
