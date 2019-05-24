<?php

namespace App\Contracts\Process;

use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Builder;

interface IQueryProcess {

    /**
     * Take the query-builder and manipulate it.
     *
     * @param Builder $builder
     * @param ApiModel $model
     * @param array $request_data
     * @return Builder $builder
     */
    public function process( Builder $builder, ApiModel $model, array $request_data);

}
