<?php

namespace App\Jobs\Api\Country;

use App\Http\Resources\Person\PersonResource;
use App\Http\Resources\State\StatesResource;
use App\Jobs\Api\RelatedIndexJob;
use App\Jobs\Api\State\StateIndexJob;
use App\Jobs\ProcessingSteps\Paginate;

class CountryRelatedIndexJob extends RelatedIndexJob
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

    public function states()
    {
        $data = $this->request_data;

        data_set($data, 'filter.country_id', $this->model->id);
        $states = StateIndexJob::dispatchNow($data);

        return new StatesResource($states);
    }

    public function president()
    {
        return new PersonResource($this->model->president);
    }

}
