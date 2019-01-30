<?php

namespace App\Http\Requests\Api\State;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Requests\Api\ApiRequest;

class StateStoreRequest extends ApiRequest
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
            'data'                          => 'required',
            'data.types'                    => 'countries',
            'data.attributes.name'          => 'required|string|nullable',
            'data.attributes.code2'         => [
                'required',
                'size:2',
                'unique:countries,code2',
            ],
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
