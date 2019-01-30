<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{

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
    
    

}
