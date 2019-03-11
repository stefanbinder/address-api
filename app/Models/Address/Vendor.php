<?php

namespace App\Models\Address;

use App\Models\ApiModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends ApiModel
{

    const ID = 'vendors';

    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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
        return $this->belongsToMany(Country::class);
    }

}
