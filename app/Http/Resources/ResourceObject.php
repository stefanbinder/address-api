<?php

namespace App\Http\Resources;

use App\Http\Resources\Person\PersonResource;
use App\Http\Resources\State\StateResource;
use App\Jobs\Api\RelationshipIndexJob;
use App\Models\ApiModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class ResourceObject extends JsonResource
{

    const DEFAULT_EMBEDS = ['links', 'attributes', 'relationships', 'includes', 'meta'];

    /**
     * @var ApiModel
     */
    protected $model;

    /**
     * Will be automatically filled
     * @var string
     */
    protected $model_name;
    protected $model_name_plural;

    protected $default_fields;
    protected $all_fields;

    /**
     * @var array
     */
    private $embed;

    /**
     * ResourceObject constructor.
     * @param mixed $resource
     * @param array $embed
     */
    public function __construct($resource, $embed = null)
    {
        parent::__construct($resource);
        $this->embed = $embed ?? self::DEFAULT_EMBEDS;
    }

    /**
     * Must return the model
     *
     * @return ApiModel
     */
    abstract protected function get_model();

    /**
     * Set the default fields which are returned by the index-method
     *
     * @return array
     */
    abstract protected function get_default_fields();

    /**
     * Set all possible fields which can be returned
     *
     * @return array
     */
    abstract protected function get_all_fields();

    /**
     * Set all possible fields which can be returned
     *
     * @return array
     */
    abstract protected function get_relationships();

    /**
     * Takes a relationship as string and returns value from RelatedJob
     *
     * @param $relationship
     * @param $request_data
     * @return mixed
     */
    abstract protected function get_relationship($relationship, $request_data);

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->model          = $this->get_model();
        $this->default_fields = $this->get_default_fields();
        $this->all_fields     = $this->get_all_fields();

        $model_name              = explode("\\", $this->model);
        $this->model_name        = strtolower($model_name[count($model_name) - 1]);
        $this->model_name_plural = Str::plural($this->model_name);

        $resource_object = [
            'id'   => (string)$this->id,
            'type' => $this->model_name_plural,
        ];

        if (in_array('links', $this->embed)) {
            $resource_object['links'] = $this->build_links();
        }
        if (in_array('attributes', $this->embed)) {
            $resource_object['attributes'] = $this->build_attributes($request);
        }
        if (in_array('relationships', $this->embed)) {
            $resource_object['relationships'] = $this->build_relationships();
        }
        if (in_array('includes', $this->embed)) {
            $resource_object['includes'] = $this->build_includes($request);
        }
        if (in_array('meta', $this->embed)) {
            $resource_object['meta'] = $this->build_meta($request);
        }

        return $resource_object;
    }

    protected function build_relationships()
    {
        $relationships = [];

        foreach ($this->get_relationships() as $relationship) {
            $relationships[$relationship] = RelationshipIndexJob::dispatchNow($this->resource, $relationship);
        }

        return $relationships;
    }

    protected function build_includes($request)
    {
        $include_data = [];

        $include_param = $request->input('include', '');
        $includes      = explode(',', $include_param);

        foreach ($includes as $include) {
            if (in_array($include, $this->get_relationships())) {
                $to_include = $this->get_relationship($include, []);

                if($to_include instanceof ResourceCollection) {
                    $to_include = $to_include->toArray($request);
                }

                if (is_array($to_include)) {
                    $include_data = array_merge($include_data, $to_include);
                } else if( $to_include instanceof Collection) {
                    $include_data = array_merge($include_data, $to_include->toArray());
                } else if($to_include) {
                    array_push($include_data, $to_include);
                }

            }
        }
        return $include_data;
    }

    protected function build_attributes($request)
    {
        $attributes = [];
        $fields     = $request->input('fields', []);

        if (array_key_exists($this->model_name_plural, $fields)) {
            $fields = explode(",", $fields[$this->model_name_plural]);
        } else {
            $fields = $this->default_fields;
        }

        foreach ($fields as $field) {
            if (in_array($field, $this->all_fields)) {
                if (method_exists($this, $field)) {
                    $attributes[$field] = $this->$field();
                } else {
                    $attributes[$field] = null;
                    \Log::warning("Function $field not implemented in resource of " . $this->model_name_plural);
                }
            }
        }

        return $attributes;
    }

    protected function build_links()
    {
        return [
            'self' => route($this->model_name_plural . '.show', [$this->model_name => $this->id])
        ];
    }

    protected function build_meta($request)
    {
        return [];
    }

}
