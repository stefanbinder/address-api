<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\DestroyJob;

class MediaDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
