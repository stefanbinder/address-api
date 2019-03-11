<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\RelatedIndexJob;
use App\Jobs\ProcessingSteps\Paginate;

class MediaRelatedIndexJob extends RelatedIndexJob
{

    /**
     * Execute the job.
     *
     * @return Paginate
     * @throws \Exception
     */
    public function handle()
    {
        return $this->process();
    }

}
