<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\UpdateJob;

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
