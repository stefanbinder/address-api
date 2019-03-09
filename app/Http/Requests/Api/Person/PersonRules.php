<?php

namespace App\Http\Requests\Api\Person;

class PersonRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                       => 'required|in:people',
            'data.attributes.given_name'      => 'required|string',
            'data.attributes.family_name'     => 'required',
            'data.attributes.email'           => 'required|email',
            'data.attributes.additional_name' => '',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                         => 'required|exists:people,id',
            'data.type'                       => 'required|in:people',
            'data.attributes.given_name'      => 'required|string',
            'data.attributes.family_name'     => 'required',
            'data.attributes.email'           => 'required|email',
            'data.attributes.additional_name' => '',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
