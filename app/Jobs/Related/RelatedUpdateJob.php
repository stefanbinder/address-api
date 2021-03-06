<?php

namespace App\Jobs\Related;

use App\Exceptions\Api\Jobs\NotFoundRelationship;
use App\Jobs\ProcessingSteps\ProcessRelations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RelatedUpdateJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $related;
    protected $request_data;
    private   $id;

    /**
     * Create a new job instance.
     *
     * @param $request_data
     * @param Model $model
     * @param string $related
     * @param $id
     */
    public function __construct($request_data, Model $model, $related, $id)
    {
        $this->request_data = $request_data;
        $this->model        = $model;
        $this->related      = $related;
        $this->id           = $id;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $related = $this->related;

        if( ! method_exists( $this->model, $related ) ) {
            throw new NotFoundRelationship($related, get_class($this->model));
        }

        $relatedModel = ProcessRelations::processRelationship($this->model->$related(), $this->request_data);
        $this->model->push();

        return $relatedModel;
    }

}
