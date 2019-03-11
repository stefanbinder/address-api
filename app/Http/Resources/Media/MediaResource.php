<?php

namespace App\Http\Resources\Media;

use App\Http\Resources\ResourceObject;
use App\Jobs\Api\Media\MediaRelatedIndexJob;
use App\Models\Media\Media;

class MediaResource extends ResourceObject
{

    protected function get_model()
    {
        return Media::class;
    }

    protected function get_default_fields()
    {
        return $this->get_all_fields();
    }

    protected function get_all_fields()
    {
        return [
            'name',
            'url',
            'filename',
            'title',
            'type',
            'created_at',
            'updated_at',
        ];
    }

    protected function get_relationships()
    {
        return [
            'country',
            'state'
        ];
    }

    protected function get_relationship($relationship, $request_data)
    {
        return MediaRelatedIndexJob::dispatchNow($request_data, $this->resource, $relationship);
    }

    public function name()
    {
        return $this->name;
    }

    public function url()
    {
        return $this->url;
    }

    public function filename()
    {
        return $this->filename;
    }

    public function title()
    {
        return $this->title;
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
