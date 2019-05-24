<?php

namespace App\Http\Resources\MediaObject;

use App\Http\Resources\ResourceObject;
use App\Jobs\Api\MediaObject\MediaObjectRelatedIndexJob;
use App\Models\MediaObject\MediaObject;

class MediaObjectResource extends ResourceObject
{

    public function get_model()
    {
        return MediaObject::class;
    }

    protected function get_default_fields()
    {
        return $this->get_all_fields();
    }

    protected function get_all_fields()
    {
        return [
            'contentSize',
            'contentUrl',
            'contentUrl1024',
            'thumbnailUrl100',
            'thumbnailUrl400',
            'headline',
            'description',
            'encodingFormat',
            'genre',
            'keywords',
            'publisher_id',
            'uploader_id',
            'service_id',
            'service_type',
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
        return MediaObjectRelatedIndexJob::dispatchNow($request_data, $this->resource, $relationship);
    }

    public function contentSize()
    {
        return $this->contentSize;
    }

    public function contentUrl()
    {
        return $this->contentUrl;
    }

    public function contentUrl1024()
    {
        return $this->contentUrl1024;
    }

    public function thumbnailUrl100()
    {
        return $this->thumbnailUrl100;
    }

    public function thumbnailUrl400()
    {
        return $this->thumbnailUrl400;
    }

    public function headline()
    {
        return $this->headline;
    }

    public function description()
    {
        return $this->description;
    }

    public function encodingFormat()
    {
        return $this->encodingFormat;
    }

    public function genre()
    {
        return $this->genre;
    }

    public function keywords()
    {
        return $this->keywords;
    }

    public function publisher_id()
    {
        return $this->publisher_id;
    }

    public function uploader_id()
    {
        return $this->uploader_id;
    }

    public function service_id()
    {
        return $this->service_id;
    }

    public function service_type()
    {
        return $this->service_type;
    }

}
