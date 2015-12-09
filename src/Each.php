<?php

namespace Enzyme\Loopy;

use ArrayAccess;
use Closure;
use Enzyme\Loopy\Filters\FilterInterface;

class Each implements LooperInterface
{
    /**
     * If this loop will go deep into the enumerated object.
     *
     * @var boolean
     */
    protected $deep;

    /**
     * Stores the current cycle value.
     *
     * @var integer
     */
    protected $cycle;

    /**
     * Stored the current index value.
     *
     * @var integer
     */
    protected $index;

    /**
     * Stored the current depth value.
     *
     * @var integer
     */
    protected $depth;

    /**
     * The optional filter to pass the key and value through
     * upon each iteration.
     *
     * @var FilterInterface
     */
    protected $filter;

    /**
     * Creates a new Each loop.
     *
     * @param bool $deep Whether to traverse deeply.
     *
     * @param FilterInterface|null $filter The optional filter to apply to each iteration.
     */
    private function __construct($deep, FilterInterface $filter = null)
    {
        $this->deep = $deep;
        $this->filter = $filter;
    }

    /**
     * Creates a new shallow Each loopy.
     *
     * @param FilterInterface|null $filter The optional filter to apply to each iteration.
     *
     * @return Each
     */
    public static function shallow(FilterInterface $filter = null)
    {
        $deep = false;

        return new static($deep, $filter);
    }

    /**
     * Creates a new deep Each loopy.
     *
     * @param FilterInterface|null $filter The optional filter to apply to each iteration.
     *
     * @return Each
     */
    public static function deep(FilterInterface $filter = null)
    {
        $deep = true;

        return new static($deep, $filter);
    }

    /**
     * {@inheritdoc}
     */
    public function begin($enumerable, Closure $function, $cycles = 1)
    {
        if($this->isEnumerable($enumerable) === false) {
            throw new InvalidLoopException('The supplied $enumerable object cannot be enumerated.');
        }

        $this->index = 0;
        $this->depth = 0;
        $this->cycle = 0;

        for ($i = 0; $i < $cycles; $i++) {
            $this->doSingleForeachCycle($enumerable, $function);
            $this->cycle++;
        }
    }

    /**
     * Performs a single foreach cycle.
     *
     * @param mixed   $enumerable The object to iterate over.
     * @param Closure $function   The callback function.
     *
     * @return void
     */
    protected function doSingleForeachCycle($enumerable, Closure $function)
    {
        foreach ($enumerable as $key => $value) {
            if ($this->canGoDeeperInto($value)) {
                $this->doSingleForeachCycle($value, $function);
            } elseif ($this->passesThroughFilter($key, $value)) {
                $this->processIteration($key, $value, $function);
            }
        }
    }

    /**
     * Checks if the given key and value pass through the filter,
     * if one exists.
     *
     * @param mixed $key   The key.
     * @param mixed $value The value.
     *
     * @return boolean
     */
    protected function passesThroughFilter($key, $value)
    {
        if ($this->filter === null) {
            return true;
        }

        return $this->filter->passes($key, $value);
    }

    /**
     * Checks whether we can go deeper into this value,
     * if the deep setting is set to true.
     *
     * @param mixed $value The value to check.
     *
     * @return boolean
     */
    protected function canGoDeeperInto($value)
    {
        return $this->deep === true && $this->isEnumerable($value);
    }

    /**
     * Checks whether the given item is enumerable.
     *
     * @param mixed $item The item.
     *
     * @return boolean
     */
    protected function isEnumerable($item)
    {
        return is_array($item) === true || ($item instanceof ArrayAccess) === true;
    }

    /**
     * Processes this iterations key and value.
     *
     * @param mixed   $key      The key.
     * @param mixed   $value    The value.
     * @param Closure $function The callback function
     *
     * @return void
     */
    protected function processIteration($key, $value, $function)
    {
        $function($this->packBag($key, $value, $function));
        $this->index++;
    }

    /**
     * Packs and returns a new bag with the given values.
     *
     * @param mixed $key   The key.
     * @param mixed $value The value.
     *
     * @return Bag
     */
    protected function packBag($key, $value)
    {
        $index = $this->index;
        $cycle = $this->cycle;
        $depth = $this->depth;

        return new Bag(compact('key', 'value', 'index', 'cycle', 'depth'));
    }
}