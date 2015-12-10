<?php

namespace Enzyme\Loopy\Filters;

class Regex implements FilterInterface
{
    /**
     * The rule to test against.
     *
     * @var mixed
     */
    protected $rule;

    /**
     * Create a new Regex filter given the regular expression.
     *
     * @param string $rule The regular expression.
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
        return preg_match($this->rule, $value) === 1;
    }
}