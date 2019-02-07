<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{

    protected function response($resource) {
        return $resource;
    }

}
