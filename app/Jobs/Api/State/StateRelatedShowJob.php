<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\RelatedShowJob;

class StateRelatedShowJob extends RelatedShowJob
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
