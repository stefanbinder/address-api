<?php

namespace App\Models\MediaObject;

use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\ApiModel;

class MediaObject extends ApiModel
{

    const ID = 'media_objects';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'media_object_objectable_id',
        'media_object_objectable_type',
        'type',
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
    ];

    const FILTERABLE = [
    ];

    const SEARCHABLE = [
    ];

    public function country()
    {
        return $this->morphTo(Country::class);
    }

    public function state()
    {
        return $this->morphTo(State::class);
    }

}
