<?php

namespace App\Exceptions\Api\Jobs;

use App\Exceptions\ApiErrorCode;
use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundRelatedException extends BaseException
{

    protected $message        = 'exceptions.not_found.related';
    protected $code           = Response::HTTP_NOT_FOUND;
    protected $api_error_code = ApiErrorCode::NOT_FOUND_RELATED;

    public function __construct($related, $related_id, $model, $model_id)
    {
        parent::__construct($this->message, $this->code);

        $this->setMessageLocalizations([
            'related'    => $related,
            'related_id' => $related_id,
            'model'      => $model,
            'model_id'   => $model_id,
        ]);
    }

}
