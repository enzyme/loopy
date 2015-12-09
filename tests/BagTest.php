<?php

use Enzyme\Loopy\Bag;

class BagTest extends PHPUnit_Framework_TestCase
{
    public function testBagStoresCorrectValue()
    {
        $expected = 'bar';
        $key = 'bar';

        $bag = new Bag(compact('key'));

        $this->assertEquals($expected, $bag->key());
    }

    public function testBagReturnsNullOnInvalidKeyLookup()
    {
        $expected = null;

        $bag = new Bag([]);

        $this->assertEquals($expected, $bag->key());
    }
}