<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\UpdateJob;

class CountryUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
