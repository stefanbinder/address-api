<?php

namespace App\Exceptions\Api\Jobs;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class CouldNotDeleteException extends BaseException
{

    protected $message        = 'exceptions.jobs.could_not_delete';
    protected $code           = Response::HTTP_INTERNAL_SERVER_ERROR;
    protected $api_error_code = ApiErrorCode::COULD_NOT_DELETE;

}
