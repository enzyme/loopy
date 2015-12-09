<?php

namespace Enzyme\Loopy;

use Closure;

interface LooperInterface
{
    /**
     * Starts a new loopy loop.
     *
     * @param mixed   $enumerable The object to iterate over.
     * @param Closure $function   The callback function.
     * @param integer $cycles     How many cycles to perform, default = 1.
     *
     * @return void
     */
    public function begin($enumerable, Closure $function, $cycles = 1);
}