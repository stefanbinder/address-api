<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\RelatedUpdateJob;

class PersonRelatedUpdateJob extends RelatedUpdateJob
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
