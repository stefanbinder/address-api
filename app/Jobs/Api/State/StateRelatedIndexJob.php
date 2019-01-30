<?php

namespace App\Jobs\Api\State;

use App\Http\Resources\Country\CountryResource;
use App\Jobs\Api\RelatedIndexJob;
use App\Jobs\ProcessingSteps\Paginate;

class StateRelatedIndexJob extends RelatedIndexJob
{

    /**
     * Execute the job.
     *
     * @return Paginate
     * @throws \Exception
     */
    public function handle()
    {
        return $this->process();
    }

    public function country()
    {
        return new CountryResource($this->model->country);
    }

}
