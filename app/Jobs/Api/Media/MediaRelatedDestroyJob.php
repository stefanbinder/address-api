<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\RelatedDestroyJob;

class MediaRelatedDestroyJob extends RelatedDestroyJob
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
