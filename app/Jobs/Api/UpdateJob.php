<?php

namespace App\Jobs\Api;

use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        $model = $this->model;
        $resourceObject = $this->request_data['data'];

        if ($this->model::ID !== $resourceObject['type']) {
            // TODO: Exception Handling
            throw new \Exception('ModelID does not fit the given type, cannot create resource');
        }

        $attributes = $this->processAttributes($resourceObject['attributes']);
        $model->update($attributes);

        if( array_key_exists('relationships', $resourceObject) ) {
            $errors = ProcessRelations::processRelationships($model, $resourceObject['relationships']);
            // TODO: maybe collect exceptions and return as error-arrays
            dd($errors);
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
