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
    ];

    protected $fillable = [
        'name',
        'code2',
        'code3',
        'capital_id',
        'region_id',
    ];

    const FILTERABLE = [
        'name',
        'code2',
        'code3',
        'capital_id',
        'region_id',
    ];

    const SEARCHABLE = [
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function capital()
    {
        return $this->hasOne(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }

}
