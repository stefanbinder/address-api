<?php

namespace App\Jobs\Api\MediaObject;

use App\Jobs\Basic\DestroyJob;

class MediaObjectDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
