<?php

if (!function_exists('convert_str_to_variations')) {

    /**
     * Takes the base string (lowercase, singular, camelCase) and transform it to different string-versions
     * @param $base
     * @return array
     */
    function convert_str_to_variations($base)
    {
        $singular_capitalize = ucfirst($base);

        $plural_lower      = \Illuminate\Support\Str::plural($base);
        $plural_capitalize = ucfirst($plural_lower);

        $snake_case        = \Illuminate\Support\Str::snake($base);
        $snake_case_plural = \Illuminate\Support\Str::plural($snake_case);

        $const_singular = strtoupper($snake_case);
        $const_plural   = strtoupper($snake_case_plural);

        $kebab_singular = \Illuminate\Support\Str::kebab($base);
        $kebab_plural   = \Illuminate\Support\Str::kebab($plural_lower);

        return [
            'singular_lower'      => $base,
            'singular_capitalize' => $singular_capitalize,
            'plural_lower'        => $plural_lower,
            'plural_capitalize'   => $plural_capitalize,
            'snake_case'          => $snake_case,
            'snake_case_plural'   => $snake_case_plural,
            'const_singular'      => $const_singular,
            'const_plural'        => $const_plural,
            'kebab_singular'      => $kebab_singular,
            'kebab_plural'        => $kebab_plural,
        ];
    }

}

if (!function_exists('build_basic_api_routes')) {

    /**
     * @param $camel_case_lower
     */
    function build_basic_api_routes($camel_case_lower)
    {
        $str_variations = convert_str_to_variations($camel_case_lower);
        $silo           = $str_variations['singular_lower'];
        $sica           = $str_variations['singular_capitalize'];
        $snpl           = $str_variations['snake_case_plural'];

        Illuminate\Support\Facades\Route::apiResource($snpl, "Api\\$sica\\${sica}Controller");

        Illuminate\Support\Facades\Route::get(
            "$snpl/{{$silo}}/relationships/{relationship}",
            "Api\\$sica\\${sica}RelationshipController@index"
        )->name("$snpl.relationship.index");

        Illuminate\Support\Facades\Route::post(
            "$snpl/{{$silo}}/relationships/{relationship}",
            "Api\\$sica\\${sica}RelationshipController@store"
        )->name("$snpl.relationship.store");

        Illuminate\Support\Facades\Route::put(
            "$snpl/{{$silo}}/relationships/{relationship}",
            "Api\\$sica\\${sica}RelationshipController@update"
        )->name("$snpl.relationship.update");

        Illuminate\Support\Facades\Route::delete(
            "$snpl/{{$silo}}/relationships/{relationship}",
            "Api\\$sica\\${sica}RelationshipController@destroy"
        )->name("$snpl.relationship.destroy");


        Illuminate\Support\Facades\Route::get(
            "$snpl/{{$silo}}/{related}",
            "Api\\$sica\\${sica}RelatedController@index"
        )->name("$snpl.related.index");

        Illuminate\Support\Facades\Route::post(
            "$snpl/{{$silo}}/{related}",
            "Api\\$sica\\${sica}RelatedController@store"
        )->name("$snpl.related.store");

        Illuminate\Support\Facades\Route::get(
            "$snpl/{{$silo}}/{related}/{id}",
            "Api\\$sica\\${sica}RelatedController@show"
        )->name("$snpl.related.show");

        Illuminate\Support\Facades\Route::put(
            "$snpl/{{$silo}}/{related}/{id}",
            "Api\\$sica\\${sica}RelatedController@update"
        )->name("$snpl.related.update");

        Illuminate\Support\Facades\Route::delete(
            "$snpl/{{$silo}}/{related}/{id}",
            "Api\\$sica\\${sica}RelatedController@destroy"
        )->name("$snpl.related.destroy");
    }
}
