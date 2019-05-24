<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Basic\UpdateJob;

class TagUpdateJob extends UpdateJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

}
