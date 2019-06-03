<?php

namespace App\Models\Address;

use App\Models\ApiModel;

class Region extends ApiModel
{

    const ID = 'regions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'parent_id',
    ];

    const FILTERABLE = [
        'name',
        'parent_id',
    ];

    const SEARCHABLE = [
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subregions()
    {
        return $this->hasMany(Region::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'id', 'parent_id');
    }

}
