<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Basic\UpdateJob;

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
