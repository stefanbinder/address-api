<?php

namespace App\Jobs\Basic;

use App\Exceptions\Api\ResourceObjectTypeError;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

abstract class StoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $request_data;

    /**
     * Create a new job instance
     * @param $request_data
     */
    public function __construct($request_data)
    {
        $this->request_data = $request_data;

        $this->init();
    }

    /**
     * Initialize the IndexJob with the wished and needed attributes
     */
    abstract protected function init();

    /**
     * Set the ApiModel, of which the processing steps will be applied
     *
     * @param ApiModel $model
     */
    public function setApiModel(ApiModel $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the stored ApiModel
     *
     * @return ApiModel|null
     * @throws \Exception
     */
    public function handle()
    {
        $model = $this->model;

        if (!$model) {
            return null;
        }

        $resourceObject = $this->request_data['data'];

        if ($model::ID !== $resourceObject['type']) {
            throw new ResourceObjectTypeError($resourceObject['type'], $model::ID);
        }

        return DB::transaction(function () use ($resourceObject, $model) {
            $attributes = $this->processAttributesBeforeCreate($resourceObject['attributes']);
            $model      = $model::create($attributes);
            $model      = $this->processModelAfterCreate($model);

            if (array_key_exists('relationships', $resourceObject)) {
                ProcessRelations::processRelationships($model, $resourceObject['relationships']);
            }

            $model->push();

            return $model;
        });

    }

    /**
     * Processes the sent attributes
     * Overwrite the method for detailed processing of attributes.
     *
     * @param array $attributes
     * @return array
     */
    protected function processAttributesBeforeCreate(array $attributes)
    {
        return $attributes;
    }

    /**
     * Process the created ApiModel
     * Overwrite the method for detailed processing of attributes.
     *
     * @param ApiModel $model
     * @return ApiModel
     */
    protected function processModelAfterCreate(ApiModel $model)
    {
        return $model;
    }

}
