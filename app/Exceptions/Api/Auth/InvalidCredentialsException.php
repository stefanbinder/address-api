<?php

namespace App\Exceptions\Api\Auth;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class InvalidCredentialsException extends BaseException
{

    protected $message = "exceptions.auth.invalid_credentials";
    protected $code = Response::HTTP_UNAUTHORIZED;
    protected $api_error_code = ApiErrorCode::AUTH_INVALID_CREDENTIALS;

}
