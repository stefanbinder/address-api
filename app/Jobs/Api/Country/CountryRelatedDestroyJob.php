<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\RelatedDestroyJob;

class CountryRelatedDestroyJob extends RelatedDestroyJob
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
