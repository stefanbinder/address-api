<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\RelatedIndexJob;
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

}
