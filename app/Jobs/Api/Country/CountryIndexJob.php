<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\IndexJob;
use App\Jobs\ProcessingSteps\Paginate;
use App\Models\Address\Country;

class CountryIndexJob extends IndexJob
{

    /**
     * Execute the job.
     *
     * @return Paginate
     */
    public function handle()
    {
        return $this->process();
    }

    protected function getEloquent()
    {
        return Country::class;
    }
}
