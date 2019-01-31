<?php

namespace App\Http\Requests\Api\Country;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Requests\Api\ApiRequest;

class CountryStoreRequest extends ApiRequest
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
            'data.type'                    => 'required',
            'data.attributes.name'         => 'required|string',
            'data.attributes.code'         => 'required',
//            'data.attributes.code'         => [
//                'required',
//                'size:2',
//                'unique:countries,code',
//            ],
            'data.attributes.inhabitants'  => '',
            'data.attributes.founded_at'   => '',
            'data.attributes.some_time'    => '',
            'data.attributes.last_visited' => '',
            'data.relationships'           => '',
        ];
    }

}
