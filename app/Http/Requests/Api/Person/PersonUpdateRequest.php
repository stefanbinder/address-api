<?php

namespace App\Http\Requests\Api\Person;

use App\Http\Requests\Api\ApiRequest;

class PersonUpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.id'                     => 'required|exists:people,id',
            'data.type'                   => 'required',
            'data.attributes.given_name'  => 'required|string',
            'data.attributes.family_name' => 'required',
            'data.attributes.email'       => 'required|email',
        ];
    }
}
