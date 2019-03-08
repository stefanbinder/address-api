<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\UpdateJob;

class StateUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
