<?php

namespace App\Models\Address;

use App\Models\ApiModel;
use App\Models\MediaObject\MediaObject;
use App\Models\Tag;
use App\Models\User\Person;

class Country extends ApiModel
{

    const ID = 'countries';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'founded_at',
        'last_visited',
    ];

    protected $fillable = [
        'name',
        'code',
        'inhabitants',
        'founded_at',
        'last_visited',
        'president_id'
    ];

    const FILTERABLE = [
        'id',
        'name',
        'code',
        'inhabitants'
    ];

    const SEARCHABLE = [
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function president()
    {
        return $this->belongsTo(Person::class, 'president_id', 'id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class);
    }

    public function flag()
    {
        return $this->morphOne(MediaObject::class, 'media_objectable')->wherePivot('flag');
    }

    public function images()
    {
        return $this->morphMany(MediaObject::class, 'media_objectable')->wherePivot('images');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

}
