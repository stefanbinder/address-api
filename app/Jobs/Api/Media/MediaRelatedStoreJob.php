<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\RelatedStoreJob;

class MediaRelatedStoreJob extends RelatedStoreJob
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
