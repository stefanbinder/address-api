<?php

namespace App\Http\Requests\Api\City;

class CityRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                  => 'required|in:cities',
            'data.attributes.name'       => 'required|string',
            'data.attributes.state_id'   => 'exists:states,id',
            'data.attributes.country_id' => 'exists:countries,id',
            'data.relationships'         => '',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                    => 'required|exists:cities,id',
            'data.type'                  => 'required|in:cities',
            'data.attributes.name'       => 'required|string',
            'data.attributes.state_id'   => 'exists:states,id',
            'data.attributes.country_id' => 'exists:countries,id',
            'data.relationships'         => '',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
