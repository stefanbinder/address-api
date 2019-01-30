<?php

namespace App\Jobs\Api\Person;

use App\Jobs\Api\IndexJob;
use App\Jobs\ProcessingSteps\Paginate;
use App\Models\User\Person;

class PersonIndexJob extends IndexJob
{

    /**
     * Execute the job.
     *
     * @return Paginate
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
