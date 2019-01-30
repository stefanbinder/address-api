<?php

namespace App\Exceptions\ProcessingSteps;

use Exception;

class ProcessingStepArgsNotValid extends Exception
{
    protected $message = 'Not a valid arg in ProcessingStep';
}
