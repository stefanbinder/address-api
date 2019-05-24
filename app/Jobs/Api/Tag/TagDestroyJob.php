<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Basic\DestroyJob;

class TagDestroyJob extends DestroyJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
