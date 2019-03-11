<?php

namespace App\Http\Requests\Api\Media;

class MediaRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                => 'required|in:media',
            'data.relationships'       => '',
            'data.attributes.name'     => '',
            'data.attributes.url'      => '',
            'data.attributes.filename' => '',
            'data.attributes.title'    => '',
            'data.attributes.type'     => '',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                  => 'required|exists:media,id',
            'data.type'                => 'required|in:media',
            'data.attributes.name'     => '',
            'data.attributes.url'      => '',
            'data.attributes.filename' => '',
            'data.attributes.title'    => '',
            'data.attributes.type'     => '',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
