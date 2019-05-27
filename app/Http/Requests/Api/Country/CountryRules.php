<?php

namespace App\Http\Requests\Api\Country;

class CountryRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                    => 'required|in:countries',
            'data.attributes.name'         => 'required|string',
            'data.attributes.code'         => 'required|unique:countries,code',
            'data.attributes.inhabitants'  => '',
            'data.attributes.founded_at'   => '',
            'data.attributes.last_visited' => '',
            'data.relationships'           => '',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                      => 'required|exists:countries,id',
            'data.type'                    => 'required|in:countries',
            'data.attributes.name'         => 'string|nullable',
            'data.attributes.code'         => 'size:2|unique:countries,id,' . $model->id,
            'data.attributes.inhabitants'  => '',
            'data.attributes.founded_at'   => '',
            'data.attributes.last_visited' => '',
            'data.relationships'           => '',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
