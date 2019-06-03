<?php

namespace App\Jobs\Api\Region;

use App\Jobs\Basic\UpdateJob;

class RegionUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
