<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class TokenNotProvidedException extends BaseException
{

    protected $message        = 'exceptions.auth.token_not_provided';
    protected $detail         = 'exceptions.auth.token_not_provided_detail';
    protected $code           = Response::HTTP_UNAUTHORIZED;
    protected $api_error_code = ApiErrorCode::AUTH_TOKEN_NOT_PROVIDED;

}
