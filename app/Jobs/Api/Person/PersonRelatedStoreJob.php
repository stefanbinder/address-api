<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\RelatedStoreJob;

class PersonRelatedStoreJob extends RelatedStoreJob
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
