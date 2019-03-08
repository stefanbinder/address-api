<?php

namespace App\Exceptions\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokenNotProvidedException extends UnauthorizedHttpException
{

    public function __construct($message = null)
    {
        if( ! $message ) {
            $message = "The Token is not provided, please send correct token as parameter or as Authorization Header.";
        }

        parent::__construct("Bearer Token", $message, $this, Response::HTTP_UNAUTHORIZED);
    }

}
