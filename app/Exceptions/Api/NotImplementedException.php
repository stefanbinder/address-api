<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class NotImplementedException extends BaseException
{

    protected $message        = 'exceptions.not_implemented';
    protected $code           = Response::HTTP_INTERNAL_SERVER_ERROR;
    protected $api_error_code = ApiErrorCode::DEFAULT_CODE;

}
