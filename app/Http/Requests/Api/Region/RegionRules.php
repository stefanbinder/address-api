<?php

namespace App\Http\Requests\Api\Region;

class RegionRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                 => 'required|in:regions',
            'data.attributes.name'      => 'required|string',
            'data.attributes.region_id' => 'exists:regions,id',
            'data.relationships'        => '',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                   => 'required|exists:regions,id',
            'data.type'                 => 'required|in:regions',
            'data.attributes.name'      => 'required|string',
            'data.attributes.region_id' => 'exists:regions,id',
            'data.relationships'        => '',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
