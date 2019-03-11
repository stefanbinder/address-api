<?php

namespace App\Models\Media;

use App\Models\Address\Country;
use App\Models\Address\State;
use App\Models\ApiModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends ApiModel
{

    const ID = 'media';

    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'url',
        'filename',
        'title',
        'type',
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
