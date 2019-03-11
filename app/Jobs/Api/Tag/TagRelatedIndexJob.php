<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Api\RelatedIndexJob;
use App\Jobs\ProcessingSteps\Paginate;

class TagRelatedIndexJob extends RelatedIndexJob
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
