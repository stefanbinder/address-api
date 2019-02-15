<?php

namespace App\Http\Requests\Api\State;

use App\Http\Requests\Api\ApiRequest;

class StateUpdateRequest extends ApiRequest
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
            'data.type'            => 'required',
            'data.attributes.name' => 'required|string',
        ];
    }
}