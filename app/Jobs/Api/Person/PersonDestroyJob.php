<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\DestroyJob;

class PersonDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
