<?php

namespace App\Http\Requests\Api\MediaObject;

class MediaObjectRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                    => 'required|in:media_objects',
            'data.attributes.media_object' => 'required',
            'data.attributes.headline'     => '',
            'data.attributes.description'  => '',
            'data.attributes.genre'        => '',
            'data.attributes.keywords'     => '',
            'data.attributes.service_id'   => '',
            'data.attributes.service_type' => '',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                  => 'required|exists:media_objects,id',
            'data.type'                => 'required|in:media_objects',
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
