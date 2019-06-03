<?php

namespace App\Jobs\Api\City;

use App\Jobs\Basic\UpdateJob;

class CityUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
