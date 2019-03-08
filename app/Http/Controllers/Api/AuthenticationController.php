<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\Auth\AuthenticationError;
use App\Exceptions\Api\Auth\InvalidCredentialsException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Authentication\RegisterRequest;
use App\Jobs\Api\Authentication\RegisterUser;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthenticationController extends ApiController
{

    /**
     * @param Request $request
     * @param JWTAuth $auth
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthenticationError
     * @throws InvalidCredentialsException
     */
    public function authenticate(Request $request, JWTAuth $auth)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = $auth->attempt($credentials)) {
                throw new InvalidCredentialsException();
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            throw new AuthenticationError();
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function register(RegisterRequest $request, JWTAuth $auth)
    {

        $user = RegisterUser::dispatchNow($request);

    }



}
