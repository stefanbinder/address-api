<?php

namespace App\Http\Requests\Api;

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
        $errorResponse = ['errors' => []];
        $errorResponse['errors'] = $this->prepareErrors($validator->errors());

        throw new HttpResponseException(response()->json(
            $errorResponse,
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }

    private function prepareErrors(MessageBag $messageBag)
    {
        $prepared = [];
        foreach($messageBag->getMessages() as $key => $error) {

            $prepared[] = [
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'title'  => 'Invalid Attribute',
                'detail' => implode(" ", $error),
                'source' => ['pointer' => $key],
                // TODO: Implement a better Exception Handling Strategy
//                'id'     => 'the-id',
//                'links'  => [],
//                'code'   => 'error-code',
//                'meta'   => [],
            ];
        }
        return $prepared;
    }

}
