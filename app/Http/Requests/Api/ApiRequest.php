<?php

namespace App\Http\Requests\Api;

use App\Exceptions\Api\Jobs\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        // The JsonApiValidationFormatter catch's that exception and formats it accordingly
        throw new ValidationException($validator);
    }

}
