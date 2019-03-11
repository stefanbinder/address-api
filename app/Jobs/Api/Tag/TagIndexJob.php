<?php

namespace App\Jobs\Api\Tag;

use App\Jobs\Api\IndexJob;
use App\Jobs\ProcessingSteps\Paginate;
use App\Models\Tag;

class TagIndexJob extends IndexJob
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
        return Tag::class;
    }
}
