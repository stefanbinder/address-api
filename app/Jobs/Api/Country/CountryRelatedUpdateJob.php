<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\RelatedUpdateJob;

class CountryRelatedUpdateJob extends RelatedUpdateJob
{

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

}