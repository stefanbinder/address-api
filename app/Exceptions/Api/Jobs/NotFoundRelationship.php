<?php

namespace App\Exceptions\Api\Jobs;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundRelationship extends BaseException
{

    protected $message        = 'exceptions.not_found.relationship';
    protected $code           = Response::HTTP_NOT_FOUND;
    protected $api_error_code = ApiErrorCode::DEFAULT_CODE;

    public function __construct($relationship, $model)
    {
        parent::__construct($this->message, $this->code);

        $this->setMessageLocalizations([
            'relationship' => $relationship,
            'model'        => $model,
        ]);

    }

}
