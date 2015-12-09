<?php

namespace Enzyme\Loopy\Filters;

class SkipNulls implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function passes($key, $value)
    {
        return $value !== null;
    }
}