<?php

namespace App\Http\Requests\Api\Person;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Requests\Api\ApiRequest;

class PersonStoreRequest extends ApiRequest
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
            'data.type'                   => 'required',
            'data.attributes.given_name'  => 'required|string',
            'data.attributes.family_name' => 'required',
            'data.attributes.email'       => 'required|email',
        ];
    }

}
