<?php

namespace App\Http\Requests\Api\Region;

use App\Http\Requests\Api\ApiRequest;

class RegionUpdateRequest extends ApiRequest
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
        return RegionRules::update($this->route('region'));
    }
}
