<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Api\RelatedUpdateJob;

class TagRelatedUpdateJob extends RelatedUpdateJob
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
