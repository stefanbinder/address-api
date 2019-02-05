<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\ValidationException;
use App\Jobs\ProcessingSteps\ProcessRelations;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class DestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ApiModel
     */
    protected $model;

    /**
     * Create a new job instance
     * @param ApiModel $model
     * @param $request_data
     */
    public function __construct($model)
    {
        $this->model        = $model;
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
     * @return array
     * @throws \Exception
     */
    public function process()
    {
        $model = $this->model;

        if($model && $model->delete()) {
            return [
                'meta' => [
                    'id' => $model->id,
                    'message' => 'deleted'
                ]
            ];
        }

        throw new NotFoundHttpException('Resource not found');
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
