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
            'data.type'                          => 'required|in:countries',
            'data.attributes.name'               => 'required|string',
            'data.attributes.code2'              => 'required|size:2|unique:countries,code2',
            'data.attributes.code3'              => 'required|size:3|unique:countries,code3',
            'data.relationships'                 => '',
            'data.relationships.region.data.id'  => 'required|exists:regions,id',
            'data.relationships.capital.data.id' => 'exists:cities,id',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                            => 'required|exists:countries,id',
            'data.type'                          => 'required|in:countries',
            'data.attributes.name'               => 'required|string',
            'data.attributes.code2'              => 'required|size:2|unique:countries,code2,' . $model->code2,
            'data.attributes.code3'              => 'required|size:3|unique:countries,code3,' . $model->code3,
            'data.relationships'                 => '',
            'data.relationships.region.data.id'  => 'required|exists:regions,id',
            'data.relationships.capital.data.id' => 'exists:cities,id',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
