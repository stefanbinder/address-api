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

        $model = $this->route('country');

        return [
            'data'                          => 'required',
            'data.types'                    => 'countries',
            'data.attributes.name'          => 'string|nullable',
            'data.attributes.code2'         => 'size:2|unique:countries,code2,'.$model->id,
            'data.attributes.code3'         => 'size:3',
            'data.attributes.capital_id'    => 'exists:cities,id',
            'data.attributes.capital'       => 'exists:cities',
            'data.attributes.region_id'     => 'exists:regions,id',
            'data.attributes.region'        => 'exists:regions',
            'data.attributes.sub_region_id' => 'exists:regions,id',
            'data.attributes.sub_region'    => 'exists:regions',
        ];
    }
}
