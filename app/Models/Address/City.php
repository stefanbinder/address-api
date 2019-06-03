<?php

namespace App\Models\Address;

use App\Models\ApiModel;

class City extends ApiModel
{

    const ID = 'cities';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'country_id',
        'state_id',
        'type',
    ];

    const FILTERABLE = [
        'name',
        'country_id',
        'state_id',
        'type',
    ];

    const SEARCHABLE = [
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
