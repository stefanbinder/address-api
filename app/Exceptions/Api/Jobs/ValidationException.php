<?php

namespace App\Exceptions\Api\Jobs;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ValidationException extends BaseException
{

    protected $message = 'exceptions.validation.default';
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $api_error_code = ApiErrorCode::VALIDATION_ERROR;

    public $validator;

    public function __construct(Validator $validator)
    {
        parent::__construct($this->message, $this->code);
        $this->validator = $validator;
    }

}
