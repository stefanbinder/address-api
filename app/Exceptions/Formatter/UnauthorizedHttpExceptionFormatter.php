<?php

namespace App\Exceptions\Formatter;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedHttpExceptionFormatter extends JsonApiFormatter
{
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        parent::format($response, $e, $reporterResponses);

        $response->setStatusCode(401);

        $response->headers->set('WWW-Authenticate', $e->getHeaders()['WWW-Authenticate']);

        return $response;
    }
}
