<?php

return [
    'default' => 'Something went wrong',
    'not_implemented' => 'That code is not implemented yet, pls contact support',

    'auth' => [
        'failed'                    => 'Authentication Error',
        'invalid_credentials'       => 'The provided credentials are wrong',
        'token_not_provided'        => 'Please login, token is not provided.',
        'token_not_provided_detail' => 'Use the authorization endpoint for retrieving and token and send the token in the Authorization request header',
    ],

    'not_found' => [
        'resource' => 'The resource :resource with id :id was not found',
        'related' => 'The related object :related with id :related_id does not exist on :model with id :model_id',
        'relationship' => 'The relationship :relationship on model :model does not exists.',
    ],

    'no_fit' => [
        'type' => 'The given type :type does not fit with our type :expected_type'
    ],

    'validation' => [
        'default' => 'Validation Error',
    ],

    'jobs' => [
        'could_not_delete' => 'Could not delete the object',
        'array_not_assignable_to_relation' => 'The given data is an array, which is not assignable to a relation which is not a list.',
    ]

];
