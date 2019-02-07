<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\IndexJob;
use App\Jobs\ProcessingSteps\Paginate;
use App\Models\Address\State;

class StateIndexJob extends IndexJob
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
        return State::class;
    }

}
