<?php

namespace App\Jobs\Basic;

use App\Exceptions\Api\NotImplementedException;
use App\Exceptions\Api\ResourceObjectTypeError;
use App\Exceptions\Api\ValidationException;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class UpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ApiModel
     */
    protected $model;
    protected $request_data;

    /**
     * Create a new job instance
     * @param ApiModel $model
     * @param $request_data
     */
    public function __construct($model, $request_data)
    {
        $this->model        = $model;
        $this->request_data = $request_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Returns the stored ApiModel
     *
     * @return ApiModel|null
     * @throws \Exception
     */
    public function process()
    {
        $model          = $this->model;
        $resourceObject = $this->request_data['data'];

        if ($this->model::ID !== $resourceObject['type']) {
            throw new ResourceObjectTypeError($resourceObject['type'], $this->model::ID);
        }

        $attributes = $this->processAttributes($resourceObject['attributes']);
        $model->update($attributes);

        if (array_key_exists('relationships', $resourceObject)) {
            ProcessRelations::processRelationships($model, $resourceObject['relationships']);
        }

        $model->save();

        return $model;

    }

    /**
     * Processes the sent attributes
     *
     * Overwrite the method for detailed processing of attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function processAttributes($attributes)
    {
        return $attributes;
    }


}
