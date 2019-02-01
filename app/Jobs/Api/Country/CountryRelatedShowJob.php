<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\RelatedShowJob;

class CountryRelatedShowJob extends RelatedShowJob
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
