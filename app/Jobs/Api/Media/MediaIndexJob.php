<?php

namespace App\Jobs\Api\Media;

use App\Jobs\Api\IndexJob;
use App\Jobs\ProcessingSteps\Paginate;
use App\Models\Media\Media;

class MediaIndexJob extends IndexJob
{

    /**
     * Execute the job.
     *
     * @return Paginate
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
