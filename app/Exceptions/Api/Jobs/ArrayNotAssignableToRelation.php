<?php

namespace App\Exceptions\Api\Jobs;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class ArrayNotAssignableToRelation extends BaseException
{

    protected $message = 'exceptions.jobs.array_not_assignable_to_relation';
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $api_error_code = ApiErrorCode::ARRAY_NOT_ASSIGNABLE_TO_RELATION;

}
