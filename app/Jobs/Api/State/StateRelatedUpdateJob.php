<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\RelatedUpdateJob;

class StateRelatedUpdateJob extends RelatedUpdateJob
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
