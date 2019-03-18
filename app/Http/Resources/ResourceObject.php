<?php

namespace App\Http\Resources;

use App\Exceptions\Api\Jobs\NotFoundRelatedException;
use App\Jobs\Api\ApiJobFactory;
use App\Jobs\Api\RelationshipIndexJob;
use App\Models\ApiModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

abstract class ResourceObject extends JsonResource
{

    public const EMBED_LINKS         = 'links';
    public const EMBED_ATTRIBUTES    = 'attributes';
    public const EMBED_RELATIONSHIPS = 'relationships';
    public const EMBED_INCLUDED      = 'included';
    public const EMBED_META          = 'meta';

    public const DEFAULT_INDEX_EMBEDS = [
        self::EMBED_LINKS,
        self::EMBED_ATTRIBUTES,
        self::EMBED_RELATIONSHIPS,
        self::EMBED_INCLUDED,
    ];

    public const DEFAULT_EMBEDS = [
        self::EMBED_LINKS,
        self::EMBED_ATTRIBUTES,
        self::EMBED_RELATIONSHIPS,
        self::EMBED_INCLUDED,
        self::EMBED_META,
    ];

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
    protected $embed;

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
    abstract public function get_model();

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

    public function with($request)
    {
        $with = [];

        if (in_array(self::EMBED_LINKS, $this->embed)) {
            $with['links'] = $this->build_links();
        }
        if (in_array(self::EMBED_INCLUDED, $this->embed)) {
            $with['included'] = $this->build_included($request);
        }
        if (in_array(self::EMBED_META, $this->embed)) {
            $with['meta'] = $this->build_meta($request);
        }

        return $with;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
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

        if (in_array(self::EMBED_ATTRIBUTES, $this->embed)) {
            $resource_object['attributes'] = $this->build_attributes($request);
        }
        if (in_array(self::EMBED_RELATIONSHIPS, $this->embed)) {
            $resource_object['relationships'] = $this->build_relationships();
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

        // See TransformIncludeAndFieldsParams Middleware, there include is prepared and manipulated
        $include_param = $request->input('include', []);

        if (!array_key_exists($this->model::ID, $include_param)) {
            return $include_data;
        }

        $included = explode(",", $include_param[$this->model::ID]);

        foreach ($included as $include) {

            if( !method_exists($this->model, $include )) {
                throw new NotFoundRelatedException($include, null, $this->model, null);
            }

            $relatedIndexJob = ApiJobFactory::relatedIndex($this->model::ID);
            $to_include      = $relatedIndexJob::dispatchNow([], $this->resource, $include);

            if ($to_include instanceof ResourceCollection) {
                $include_data = $include_data->merge($to_include);
            } else {

                // We retrieve related data, if related data does not exists, an data-null array is returned.
                // Do not include empty arrays with data-null objects
                if( ! (array_key_exists('data', $to_include) && $to_include['data'] === null ) ) {
                    $include_data = $include_data->push($to_include);
                }

            }

        }

        return $include_data;
    }

    /**
     * Get either the fields-param from Request or takes the default-fields from extended ResourceObject
     * Returns just the attributes which are given.
     *
     * @param $request
     * @return array
     */
    protected function build_attributes($request)
    {
        $attributes = [];
        $modelId    = $this->model::ID;

        // See TransformIncludeAndFieldsParams Middleware, there include is prepared and manipulated
        $fields = $request->input('fields', []);

        if (array_key_exists($modelId, $fields)) {
            $fields = explode(",", $fields[$modelId]);
        } else {
            $fields = $this->default_fields;
        }

        foreach ($fields as $field) {
            if (in_array($field, $this->all_fields)) {
                if (method_exists($this, $field)) {
                    $attributes[$field] = $this->$field();
                } else {
                    $attributes[$field] = null;
                    \Log::warning("Attribute '$field' not available in ResourceObject of $modelId");
                }
            } else {
                \Log::warning("Attribute '$field' not whitelisted in ResourceObject of $modelId");
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
