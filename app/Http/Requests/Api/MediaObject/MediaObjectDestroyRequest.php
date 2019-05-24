<?php

namespace App\Http\Requests\Api\MediaObject;

use App\Http\Requests\Api\ApiRequest;

class MediaObjectDestroyRequest extends ApiRequest
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
        return MediaObjectRules::destroy($this->route('media_object'));
    }
}
