<?php

namespace App\Models;

use App\Models\Address\Country;
use App\Models\Address\State;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends ApiModel
{

    const ID = 'tags';

    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'founded_at',
        'last_visited',
    ];

    protected $fillable = [
        'name',
    ];

    const FILTERABLE = [
    ];

    const SEARCHABLE = [
    ];


    public function countries()
    {
        return $this->morphedByMany(Country::class, 'tagable');
    }

    public function states()
    {
        return $this->morphedByMany(State::class, 'tagable');
    }

}
