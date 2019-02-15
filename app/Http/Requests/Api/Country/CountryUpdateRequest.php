<?php

namespace App\Http\Requests\Api\Country;

use App\Http\Requests\Api\ApiRequest;

class CountryUpdateRequest extends ApiRequest
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
        $model = $this->route('country');

        return [
            'data.id'                       => 'required|exists:countries,id',
            'data.type'                     => 'required',
            'data.attributes.name'          => 'string|nullable',
            'data.attributes.code'          => 'size:2|unique:countries,id,' . $model->id,
            'data.attributes.inhabitants'  => '',
            'data.attributes.founded_at'   => '',
            'data.attributes.some_time'    => '',
            'data.attributes.last_visited' => '',
            'data.relationships'           => '',
        ];
    }
}
