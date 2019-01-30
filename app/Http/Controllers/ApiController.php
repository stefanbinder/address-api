<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ApiController extends Controller
{

    protected function response($resource) {
        return $resource;
    }

}
