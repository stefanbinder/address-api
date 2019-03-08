<?php

namespace App\Http\Requests\Api\Relation;

use App\Http\Requests\Api\ApiRequest;

class RelatedStoreRequest extends ApiRequest
{

    private $relatedRequest = null;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function validated()
    {
        $related = $this->route('related');
        $type    = $this->input('data.type');

        $name                 = "App\Http\Requests\Api\State\StateStoreRequest";
        $this->relatedRequest = new $name($this->query, $this->request, $this->attributes, $this->cookies, $this->files, $this->server, $this->content);

        return $this->getValidatorInstance()->validate();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->relatedRequest->authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->relatedRequest->rules();
    }

}
