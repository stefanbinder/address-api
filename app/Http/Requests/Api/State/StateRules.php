<?php

namespace App\Http\Requests\Api\State;

class StateRules
{
    public static function index()
    {
        return [];
    }

    public static function store()
    {
        return [
            'data.type'                  => 'required|in:states',
            'data.attributes.name'       => 'required|string|nullable',
        ];
    }

    public static function show($model)
    {
        return [];
    }

    public static function update($model)
    {
        return [
            'data.id'                    => 'required|exists:states,id',
            'data.type'                  => 'required|in:states',
            'data.attributes.name'       => 'required|string|nullable',
        ];
    }

    public static function destroy($model)
    {
        return [];
    }

}
