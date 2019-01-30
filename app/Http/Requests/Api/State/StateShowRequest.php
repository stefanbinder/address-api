<?php

namespace App\Http\Requests\Api\State;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Support\Facades\Request;

class StateShowRequest extends ApiRequest
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
        ];
    }
}
