<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\RelatedStoreJob;

class CountryRelatedStoreJob extends RelatedStoreJob
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
