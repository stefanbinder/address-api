<?php

use App\Exceptions\BaseException;
use Optimus\Heimdal\Formatters;

return [
    'add_cors_headers' => true,

    // Has to be in prioritized order, e.g. highest priority first.
    'formatters' => [
//        SymfonyException\UnprocessableEntityHttpException::class => Formatters\UnprocessableEntityHttpExceptionFormatter::class,
//        SymfonyException\UnauthorizedHttpException::class => \App\Exceptions\Formatter\UnauthorizedHttpExceptionFormatter::class,
        \App\Exceptions\Api\Jobs\ValidationException::class => \App\Exceptions\Formatters\JsonApiValidationFormatter::class,
        BaseException::class => \App\Exceptions\Formatters\JsonApiFormatter::class,
        Exception::class => Formatters\ExceptionFormatter::class,
    ],

    'response_factory' => \Optimus\Heimdal\ResponseFactory::class,

    'reporters' => [
        /*'sentry' => [
            'class'  => \Optimus\Heimdal\Reporters\SentryReporter::class,
            'config' => [
                'dsn' => '',
                // For extra options see https://docs.sentry.io/clients/php/config/
                // php version and environment are automatically added.
                'sentry_options' => []
            ]
        ]*/
    ],

    'server_error_production' => 'An error occurred.'
];
