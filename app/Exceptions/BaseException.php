<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BaseException extends Exception
{
    protected $api_error_code;
    protected $detail;
    protected $message_localizations = [];

    /**
     * @return array
     */
    public function getMessageLocalizations(): array
    {
        return $this->message_localizations;
    }

    /**
     * @param mixed $message_localizations
     */
    public function setMessageLocalizations(array $message_localizations): void
    {
        $this->message_localizations = $message_localizations;
    }

    /**
     * @return string|number
     */
    public function getApiErrorCode()
    {
        return $this->api_error_code;
    }

    /**
     * @param string|number $api_error_code
     */
    public function setApiErrorCode($api_error_code): void
    {
        $this->api_error_code = $api_error_code;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail($detail): void
    {
        $this->detail = $detail;
    }

}
