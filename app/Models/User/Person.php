<?php

namespace App\Models\User;

use App\Models\Address\Country;
use App\Models\ApiModel;

class Person extends ApiModel
{

    const ID = 'people';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'additional_name',
        'given_name',
        'family_name',
        'email',
    ];

    const FILTERABLE = [
        'additional_name',
        'given_name',
        'family_name',
        'email',
    ];

    const SEARCHABLE = [
    ];

    public function president_of_country()
    {
        return $this->belongsTo(Country::class, 'id', 'president_id');
    }

}
