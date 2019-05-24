<?php

namespace App\Contracts\Process;

interface IProcessStep {

    /**
     * Takes parameters inside the $args array and process something
     *
     * @param array $args
     * @return array $return
     */
    public function process( array $args );

}
