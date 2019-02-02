<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\StoreJob;
use App\Jobs\Api\UpdateJob;
use App\Models\User\Person;

class PersonUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
