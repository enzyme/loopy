<?php

namespace Enzyme\Loopy\Filters;

class Equal implements FilterInterface
{
    /**
     * The rule to test against.
     *
     * @var mixed
     */
    protected $rule;

    /**
     * Create a new Equal filter given the value to check
     * equality against.
     *
     * @param mixed $rule The value to check against.
     */
    public function __construct($rule)
    {
        $this->rule = $rule;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($key, $value)
    {
        return $value === $this->rule;
    }
}