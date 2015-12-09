<?php

namespace Enzyme\Loopy\Filters;

interface FilterInterface
{
    /**
     * Checks whether the given key and value pass the given test.
     *
     * @param mixed $key   The key.
     * @param mixed $value The value.
     *
     * @return boolean
     */
    public function passes($key, $value);
}