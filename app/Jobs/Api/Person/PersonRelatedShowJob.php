<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\RelatedShowJob;

class PersonRelatedShowJob extends RelatedShowJob
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
