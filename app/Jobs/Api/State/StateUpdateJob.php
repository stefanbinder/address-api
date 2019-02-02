<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\StoreJob;
use App\Jobs\Api\UpdateJob;
use App\Models\Address\State;

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
