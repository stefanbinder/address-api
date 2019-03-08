<?php

namespace App\Exceptions\Api\Auth;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationError extends BaseException
{

    protected $message = "exceptions.auth.failed";
    protected $code = Response::HTTP_BAD_REQUEST;
    protected $api_error_code = ApiErrorCode::AUTH_FAILED;

}
