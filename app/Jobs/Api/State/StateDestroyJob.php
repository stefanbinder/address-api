<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\DestroyJob;

class StateDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
