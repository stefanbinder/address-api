<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Api\StoreJob;
use App\Models\Tag;

class TagStoreJob extends StoreJob
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
        return Tag::class;
    }
}
