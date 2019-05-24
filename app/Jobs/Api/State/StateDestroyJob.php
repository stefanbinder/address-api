<?php

namespace App\Jobs\Api\State;

use App\Jobs\Basic\DestroyJob;

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
