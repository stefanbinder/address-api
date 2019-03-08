<?php

namespace App\Jobs\Api;

use App\Exceptions\Api\Jobs\CouldNotDeleteException;
use App\Exceptions\Api\ValidationException;
use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $this->model = $model;
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

        if ($model->deleted_at) {
            return [
                'meta' => [
                    'id'      => $model->id,
                    'message' => 'It was already deleted on ' . $model->deleted_at->toDateTimeString(),
                ]
            ];
        } else if ($model->delete()) {
            return [
                'meta' => [
                    'id'      => $model->id,
                    'message' => 'deleted'
                ]
            ];
        } else {
            throw new CouldNotDeleteException();
        }
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
