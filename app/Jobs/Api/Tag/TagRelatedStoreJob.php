<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Api\RelatedStoreJob;

class TagRelatedStoreJob extends RelatedStoreJob
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
