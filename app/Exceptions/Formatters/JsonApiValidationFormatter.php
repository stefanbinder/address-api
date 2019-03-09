<?php

namespace App\Exceptions\Formatters;

use App\Exceptions\Api\Jobs\ValidationException;
use Exception;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\BaseFormatter;

class JsonApiValidationFormatter extends BaseFormatter
{
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $errors = ['errors' => []];

        if ($e instanceof ValidationException) {
            $validator = $e->validator;

            foreach ($validator->errors()->getMessages() as $key => $error) {

                $validation_error = [
                    'title'  => implode(" ", $error),
                    'detail' => '',
                    'source' => ['pointer' => $key],
                    'status' => $e->getCode(),
                    'code'   => $e->getApiErrorCode(),
                    // 'id'     => 'the-id',
                    // 'links'  => [],
                    // 'code'   => 'error-code',
                    // 'meta'   => [],
                ];

                if ($this->debug) {
                    $validation_error['exception'] = get_class($e);
                    $validation_error['line']      = $e->getLine();
                    $validation_error['file']      = $e->getFile();
                }

                $errors['errors'][] = $validation_error;
            }
        }

        $response->setStatusCode($e->getCode());
        $response->setData($errors);

    }

}
