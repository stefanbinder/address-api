<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Api\RelatedDestroyJob;

class TagRelatedDestroyJob extends RelatedDestroyJob
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
