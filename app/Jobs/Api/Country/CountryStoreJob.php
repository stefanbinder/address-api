<?php

namespace App\Jobs\Api\Country;

use App\Jobs\Api\StoreJob;
use App\Models\Address\Country;

class CountryStoreJob extends StoreJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

    protected function getEloquent()
    {
        return Country::class;
    }
}
