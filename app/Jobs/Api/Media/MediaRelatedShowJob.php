<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\RelatedShowJob;

class MediaRelatedShowJob extends RelatedShowJob
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
