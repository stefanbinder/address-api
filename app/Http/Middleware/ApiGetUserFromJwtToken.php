<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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
     */
    public function handle($request, Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            throw new UnauthorizedHttpException("Bearer Token", "Your are not authorized, Token not provided");
        }

        $user = $this->auth->authenticate($token);

        if (! $user) {
            throw new ModelNotFoundException(User::class);
        }

        return $next($request);
    }
}
