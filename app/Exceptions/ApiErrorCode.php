<?php

namespace App\Exceptions;

class ApiErrorCode
{

    const DEFAULT_CODE = 1;

    const NOT_FOUND          = 100;
    const NOT_FOUND_RESOURCE = 101;
    const NOT_FOUND_RELATED  = 102;

    const UNPROCESSABLE = 200;

    const UNPROCESSABLE_TYPE = 201;
    const AUTH               = 300;
    const AUTH_FAILED        = 301;

    const AUTH_INVALID_CREDENTIALS = 302;
    const AUTH_TOKEN_NOT_PROVIDED  = 310;
    const AUTH_TOKEN_INVALID       = 311;

    const AUTH_TOKEN_EXPIRED = 312;

    const VALIDATION_ERROR                 = 500;

    const COULD_NOT_DELETE                 = 1000;
    const ARRAY_NOT_ASSIGNABLE_TO_RELATION = 1001;


}
