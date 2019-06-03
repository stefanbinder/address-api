<?php

namespace App\Jobs\Api\City;

use App\Jobs\Basic\DestroyJob;

class CityDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
