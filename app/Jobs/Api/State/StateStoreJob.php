<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\StoreJob;
use App\Models\Address\State;

class StateStoreJob extends StoreJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

    protected function getEloquent()
    {
        return State::class;
    }
}
