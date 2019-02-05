<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\DestroyJob;

class CountryDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
