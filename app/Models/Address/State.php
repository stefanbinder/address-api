<?php

namespace App\Models\Address;

use App\Models\ApiModel;
use App\Models\MediaObject\MediaObject;
use App\Models\Tag;

class State extends ApiModel
{

    const ID = 'states';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'country_id',
    ];

    const FILTERABLE = [
        'name',
        'country_id'
    ];

    const SEARCHABLE = [
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function media_object()
    {
        return $this->morphOne(MediaObject::class, 'media_objectable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

}
