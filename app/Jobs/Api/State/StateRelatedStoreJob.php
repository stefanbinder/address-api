<?php

namespace App\Jobs\Api\State;

use App\Jobs\Api\RelatedStoreJob;

class StateRelatedStoreJob extends RelatedStoreJob
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
