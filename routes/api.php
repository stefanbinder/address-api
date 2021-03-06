<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('authenticate', 'Api\AuthenticationController@authenticate');
Route::post('register', 'Api\AuthenticationController@register');

build_basic_api_routes('country');
build_basic_api_routes('state');
build_basic_api_routes('city');
build_basic_api_routes('region');
build_basic_api_routes('person');
build_basic_api_routes('tag');
build_basic_api_routes('mediaObject');
