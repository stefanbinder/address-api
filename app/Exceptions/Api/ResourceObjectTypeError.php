<?php

namespace App\Exceptions\Api;

use Exception;

class ResourceObjectTypeError extends Exception
{

    public function __construct($givenType, $expectedType)
    {
        $message = 'Your given relationship-type "'.$givenType.'" does not fit with our ID "'.$expectedType.'"';
        parent::__construct($message, 422);
    }

}
