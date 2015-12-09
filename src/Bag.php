<?php

namespace Enzyme\Loopy;

class Bag
{
    /**
     * The internal data store for this bag.
     *
     * @var array
     */
    protected $store = [];

    /**
     * Create a new bag with the given store data.
     *
     * @param array $store The associated data.
     */
    public function __construct($store)
    {
        $this->store = $store;
    }

    /**
     * Magic method to fetch data from the store.
     *
     * @param string $name The name of value to fetch.
     * @param mixed  $args Associated arguments (ignored).
     *
     * @return mixed|null The value.
     */
    public function __call($name, $args)
    {
        if (array_key_exists($name, $this->store)) {
            return $this->store[$name];
        }

        return null;
    }
}