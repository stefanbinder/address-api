<?php

namespace App\Jobs\Api;

use App\Models\ApiModel;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;

class RelationshipIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $relationship;

    /**
     * Create a new job instance.
     *
     * @param ApiModel $model
     * @param string $relationship
     */
    public function __construct(ApiModel $model, $relationship)
    {
        $this->model        = $model;
        $this->relationship = $relationship;
    }

    /**
     * Execute the job.
     *
     * @return array
     * @throws \Exception
     */
    public function handle()
    {
        return $this->process();
    }

    /**
     * @throws \Exception
     */
    public function process()
    {
        $model        = $this->model;
        $relationship = $this->relationship;

        $identifier_object = $model->get_identifier_object_of_relation($relationship);

        $model_name = explode("\\", get_class($model));
        $model_name = $model_name[ count($model_name) - 1 ];

        $self_link    = route($model::ID . '.relationship.index', [$model_name => $model->id, 'relationship' => $relationship]);
        $related_link = route($model::ID . '.related.index', [$model_name => $model->id, 'related' => $relationship]);

        $relationships = [
            'links' => [
                'self'    => $self_link,
                'related' => $related_link,
            ],
            'data'  => $identifier_object
        ];

        return $relationships;

    }




}
