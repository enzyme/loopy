<?php

namespace Enzyme\Loopy\Filters;

class Less implements FilterInterface
{
    /**
     * The rule to test against.
     *
     * @var mixed
     */
    protected $rule;

    /**
     * Wether or not to test less than or equal too.
     *
     * @var boolean
     */
    protected $or_equal;

    /**
     * Create a new Less filter given the value to test against
     * and whether to perform a less than or equal too check.
     *
     * @param mixed   $rule     The value to check against.
     * @param boolean $or_equal Whether to perform less than or equal too.
     */
    public function __construct($rule, $or_equal = false)
    {
        $this->rule = $rule;
        $this->or_equal = $or_equal;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($key, $value)
    {
        if (is_numeric($value) === false) {
            return false;
        }

        return $this->or_equal === true
            ? $value <= $this->rule
            : $value < $this->rule;
    }
}