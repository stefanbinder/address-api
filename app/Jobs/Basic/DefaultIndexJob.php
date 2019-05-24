<?php

namespace App\Jobs\Basic;

use App\Jobs\ProcessingSteps\EagerLoadingProcess;
use App\Jobs\ProcessingSteps\OrderingProcess;
use App\Tools\Filter\SimpleEqualsFilter;
use App\Tools\Paginator\InBuildLengthAwarePaginator;

class DefaultIndexJob extends IndexJob
{

    protected function init()
    {
        $this->setFilter( new SimpleEqualsFilter() );
        $this->setPagination( new InBuildLengthAwarePaginator() );

        $this->addQueryProcess( new EagerLoadingProcess() );
        $this->addQueryProcess( new OrderingProcess() );
    }

}
