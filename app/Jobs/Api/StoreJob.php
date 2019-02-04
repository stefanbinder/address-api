<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\ValidationException;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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
        $this->model        = $this->getEloquent();
        $this->request_data = $request_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Returns the eloquent-model which is used in the IndexJob
     *
     * @return Model
     */
    abstract protected function getEloquent();

    /**
     * Returns the stored ApiModel
     *
     * @return ApiModel|null
     * @throws \Exception
     */
    public function process()
    {
        $resourceObject = $this->request_data['data'];

        if ($this->model::ID !== $resourceObject['type']) {
            // TODO: Exception Handling
            throw new \Exception('ModelID does not fit the given type, cannot create resource');
        }

        return DB::transaction(function() use($resourceObject) {
            $attributes = $this->processAttributes($resourceObject['attributes']);
            $model      = $this->model::create($attributes);

            if( array_key_exists('relationships', $resourceObject) ) {
                $errors = ProcessRelations::processRelationships($model, $resourceObject['relationships']);

                if($errors) {
                    throw new ValidationException("Could not store relationships", $errors);
                }

            }

            $model->save();

            return $model;
        });

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
