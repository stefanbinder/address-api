<?php

namespace App\Jobs\Api\Region;

use App\Jobs\Basic\DestroyJob;

class RegionDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
