<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class TokenInvalidException extends BaseException
{

    protected $message = "The Token is invalid.";
    protected $code = Response::HTTP_UNAUTHORIZED;
    protected $api_error_code = ApiErrorCode::AUTH_TOKEN_INVALID;

}
