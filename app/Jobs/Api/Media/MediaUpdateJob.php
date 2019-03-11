<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\UpdateJob;

class MediaUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
