<?php

namespace App\Http\Requests\Api;

use Dotenv\Exception\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

abstract class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    protected function failedValidation(Validator $validator)
    {
        $errorResponse = [];

        $errorResponse['errors'] = $this->prepareErrors($validator->errors());
        $errorResponse['id'] = 'FUTURE-FEATURE';
        $errorResponse['links'] = 'FUTURE-FEATURE';
        // TODO: Implementing all possible error-information of jsonapi.org
        // https://jsonapi.org/format/#error-objects

        throw new HttpResponseException(response()->json(
            $errorResponse,
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }

    private function prepareErrors(MessageBag $messageBag)
    {
        $prepared = [];
        foreach($messageBag->getMessages() as $key => $error) {

            $key = str_replace('data.', '', $key);
            $error = str_replace('data.', '', $error);

            $prepared[$key] = $error;
        }
        return $prepared;
    }

}
