<?php

namespace App\Http\Resources;

class ResourceCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{

    public function with($request)
    {
        return [
            'included' => $this->build_included($request)
        ];
    }

    /**
     * Get include-param from Request and include all resources into the ResourceObject
     *
     * @param $request
     * @return array
     * @throws \Exception
     */
    protected function build_included($request)
    {
        $include_data = collect();

        foreach($this->collection as $resource) {
            $withData = $resource->with($request);

            if(array_key_exists('included', $withData)) {
                $include_data = $include_data->merge($withData['included']);
            }

        }

        return $include_data;
    }

}
