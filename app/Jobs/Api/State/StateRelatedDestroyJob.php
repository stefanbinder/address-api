<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\RelatedDestroyJob;

class StateRelatedDestroyJob extends RelatedDestroyJob
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
