<?php

namespace App\Http\Middleware;

use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\TokenInvalidException;
use App\Exceptions\Api\TokenNotProvidedException;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class ApiGetUserFromJwtToken
{

    /**
     * @var JWTAuth
     */
    private $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws NotFoundException
     * @throws \App\Exceptions\Api\TokenExpiredException
     * @throws TokenInvalidException
     * @throws TokenNotProvidedException
     */
    public function handle($request, Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            throw new TokenNotProvidedException();
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            throw new \App\Exceptions\Api\TokenExpiredException();
        } catch (JWTException $e) {
            throw new TokenInvalidException();
        }

        if (! $user) {
            throw new NotFoundException('User');
        }

        return $next($request);

    }
}
