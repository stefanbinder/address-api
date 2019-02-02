<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\StoreJob;
use App\Jobs\Api\UpdateJob;
use App\Models\Address\Country;

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
