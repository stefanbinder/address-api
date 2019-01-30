<?php

namespace App\Jobs\Api\Person;

use App\Http\Resources\Country\CountryResource;
use App\Jobs\Api\RelatedIndexJob;
use App\Jobs\ProcessingSteps\Paginate;

class PersonRelatedIndexJob extends RelatedIndexJob
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

    public function president_of_country()
    {
        return new CountryResource($this->model->president_of_country);
    }

}
