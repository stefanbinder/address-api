<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\RelatedUpdateJob;

class MediaRelatedUpdateJob extends RelatedUpdateJob
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
