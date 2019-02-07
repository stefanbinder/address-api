<?php

namespace App\Http\Middleware;

use Closure;

class TransformIncludeAndFieldsParams
{

    /**
     * Handle an incoming request and transform the fields "include" and "fields" into usable array
     *
     * Example:
     *
     * The Request /api/countries?include=states,states.districts,president
     *
     * gets transformed into:
     * [
     *      'countries' => ['states', 'president'],
     *      'states' => ['districts']
     * ]
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->prepareRequestFor($request, 'include');
        $this->prepareRequestFor($request, 'fields');

        return $next($request);
    }

    private function prepareRequestFor($request, $field)
    {
        $preparation = $request->input($field);

        if( !$preparation ) {
            return null;
        }

        /**
         * $preparation should either be a string "relation1,relation2" or an array with the relations
         * If just the string is given, we are transforming the string into an array with the given URL as indicator
         */
        if( ! is_array($preparation) ) {
            $routeName = $request->route()->getName();

            // routeName is eg. "countries.index", we just take the first part of a route as baseName
            $baseName = explode(".", $routeName)[0];

            $request->merge([
                $field => [
                    $baseName => $preparation
                ]
            ]);
        }
    }

}
