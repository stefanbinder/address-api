<?php

namespace App\Http\Requests\Api\City;

use App\Http\Requests\Api\ApiRequest;

class CityUpdateRequest extends ApiRequest
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
        return CityRules::update($this->route('city'));
    }
}
