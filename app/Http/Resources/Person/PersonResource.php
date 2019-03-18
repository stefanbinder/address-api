<?php

namespace App\Http\Resources\Person;

use App\Http\Resources\ResourceObject;
use App\Jobs\Api\Person\PersonRelatedIndexJob;
use App\Models\User\Person;

class PersonResource extends ResourceObject
{

    public function get_model()
    {
        return Person::class;
    }

    protected function get_default_fields()
    {
        return $this->get_all_fields();
    }

    protected function get_all_fields()
    {
        return [
            'additional_name',
            'given_name',
            'family_name',
            'email',
        ];
    }

    protected function get_relationships()
    {
        return [
            'president_of_country'
        ];
    }

    protected function get_relationship($relationship, $request_data)
    {
        return PersonRelatedIndexJob::dispatchNow($request_data, $this->resource, $relationship);
    }

    public function additional_name()
    {
        return $this->additional_name;
    }

    public function given_name()
    {
        return $this->given_name;
    }

    public function family_name()
    {
        return $this->family_name;
    }

    public function email()
    {
        return $this->email;
    }

    public function created_at()
    {
        return (string)$this->created_at;
    }

    public function updated_at()
    {
        return (string)$this->updated_at;
    }

}
