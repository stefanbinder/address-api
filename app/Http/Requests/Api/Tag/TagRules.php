<?php

namespace App\Http\Requests\Api\Tag;

class TagRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                    => 'required|in:tags',
            'data.attributes.name'         => 'required|string',
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
            'data.id'                      => 'required|exists:tags,id',
            'data.type'                    => 'required|in:tags',
            'data.attributes.name'         => 'string|nullable',
            'data.relationships'           => '',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
