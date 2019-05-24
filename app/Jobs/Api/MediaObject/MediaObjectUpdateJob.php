<?php

namespace App\Jobs\Api\MediaObject;

use App\Jobs\Basic\UpdateJob;

class MediaObjectUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
