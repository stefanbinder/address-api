<?php

namespace App\Exceptions\Api;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends BaseException
{

    protected $message        = 'exceptions.not_found.resource';
    protected $code           = Response::HTTP_NOT_FOUND;
    protected $api_error_code = ApiErrorCode::AUTH_TOKEN_NOT_PROVIDED;

    public function __construct($resource, $id = null)
    {
        parent::__construct($this->message, $this->code);

        $this->setMessageLocalizations([
            'resource' => $resource,
            'id'       => $id,
        ]);
    }

}
