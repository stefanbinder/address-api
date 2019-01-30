<?php

namespace App\Http\Resources\State;

use App\Http\Resources\ResourceObject;
use App\Jobs\Api\State\StateRelatedIndexJob;
use App\Models\Address\State;

class StateResource extends ResourceObject
{

    protected function get_model()
    {
        return State::class;
    }

    protected function get_default_fields()
    {
        return $this->get_all_fields();
    }

    protected function get_all_fields()
    {
        return [
            'name',
            'country_id',
            'created_at',
            'updated_at',
        ];
    }

    protected function get_relationships()
    {
        return [
            'country'
        ];
    }

    protected function get_relationship($relationship, $request_data)
    {
        return StateRelatedIndexJob::dispatchNow($request_data, $this->resource, $relationship);
    }

    public function name()
    {
        return $this->name;
    }

    public function country_id()
    {
        return $this->country_id;
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
