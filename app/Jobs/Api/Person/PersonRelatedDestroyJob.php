<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\RelatedDestroyJob;

class PersonRelatedDestroyJob extends RelatedDestroyJob
{

    /**
     * Execute the job.
     *
     * @return array
     * @throws \Exception
     */
    public function handle()
    {
        return $this->process();
    }

}
