<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\StoreJob;
use App\Models\Media\Media;

class MediaStoreJob extends StoreJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        return $this->process();
    }

    protected function getEloquent()
    {
        return Media::class;
    }
}
