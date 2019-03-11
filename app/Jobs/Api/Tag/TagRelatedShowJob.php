<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Api\RelatedShowJob;

class TagRelatedShowJob extends RelatedShowJob
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
