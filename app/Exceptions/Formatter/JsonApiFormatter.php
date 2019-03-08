<?php

namespace App\Exceptions\Formatter;

use Exception;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\BaseFormatter;

class JsonApiFormatter extends BaseFormatter
{
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $errors = ['errors' => []];

        // TODO: Implement a better Exception Handling Strategy
        $data = [
            'title'  => 'An error occurred',
            'detail' => $e->getMessage(),
            'status' => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
//            'id'     => 'the-id',
//            'links'  => ['about' => 'http://errors.domain.com/1234'],
//            'code'   => 'error-code',
//            'source' => '',
//            'meta'   => [],
        ];

        if ($this->debug) {
            $data['exception'] = get_class($e);
            $data['line']      = $e->getLine();
            $data['file']      = $e->getFile();
        }

        $errors['errors'][] = $data;

        $response->setStatusCode($e->getStatusCode());

        $response->setData($errors);

    }
}
