<?php

namespace App\Models\Address;

use App\Models\ApiModel;
use App\Models\Media\Media;
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
        'some_time',
        'last_visited',
        'president_id'
    ];

    const FILTERABLE = [
        'id',
        'name',
        'code',
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

    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

}
