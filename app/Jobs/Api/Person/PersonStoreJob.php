<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\StoreJob;
use App\Models\User\Person;

class PersonStoreJob extends StoreJob
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
        return Person::class;
    }
}
