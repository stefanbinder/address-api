<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class TokenExpiredException extends BaseException
{

    protected $message = "The Token is expired, please request new token.";
    protected $code = Response::HTTP_UNAUTHORIZED;
    protected $api_error_code = ApiErrorCode::AUTH_TOKEN_EXPIRED;

}
