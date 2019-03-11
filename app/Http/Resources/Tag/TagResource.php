<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\ResourceObject;
use App\Jobs\Api\Tag\TagRelatedIndexJob;
use App\Models\Tag;

class TagResource extends ResourceObject
{

    protected function get_model()
    {
        return Tag::class;
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
            'countries',
            'states',
        ];
    }

    protected function get_relationship($relationship, $request_data)
    {
        return TagRelatedIndexJob::dispatchNow($request_data, $this->resource, $relationship);
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
