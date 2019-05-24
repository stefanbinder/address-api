<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Basic\DestroyJob;

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
