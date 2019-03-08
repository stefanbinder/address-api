<?php

namespace App\Exceptions\Formatters;

use App\Exceptions\BaseException;
use Exception;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\BaseFormatter;

class JsonApiFormatter extends BaseFormatter
{
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $errors = ['errors' => []];

        $error = [
            'status' => $e->getCode(),
            'code'   => null,
            // 'id'     => 'the-id',
            // 'links'  => ['about' => 'http://errors.domain.com/1234'],
            // 'source' => '',
            // 'meta'   => [],
        ];

        if($e instanceof BaseException) {
           $error['title'] = __($e->getMessage(), $e->getMessageLocalizations());
           $error['detail'] = __($e->getDetail());
           $error['code'] = $e->getApiErrorCode();
        } else {
            $error['title'] = __($e->getMessage());
        }

        if ($this->debug) {
            $error['exception'] = get_class($e);
            $error['line']      = $e->getLine();
            $error['file']      = $e->getFile();
            $error['trace']     = $e->getTrace();
        }

        $errors['errors'][] = $error;

        $response->setStatusCode($e->getCode());

        $response->setData($errors);

    }
}
