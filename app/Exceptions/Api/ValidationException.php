<?php

namespace App\Exceptions\Api;

use Exception;

class ValidationException extends Exception
{

    public function __construct($message = null, $errors = [])
    {
        if( ! $message ) {
            $message = "Validation Error";
        }

        parent::__construct($message, 422);
    }

}
