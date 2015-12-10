<?php

use Enzyme\Loopy\Each;
use Enzyme\Loopy\Filters\Greater;

class GreaterFilterTest extends PHPUnit_Framework_TestCase
{
    public function testPassesThroughFilterSuccess()
    {
        $filter = new Greater(5);
        $expected = true;

        $key = 1;
        $value = 6;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $filter = new Greater(1009);

        $key = null;
        $value = 1010;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testPassesThroughFilterFailure()
    {
        $filter = new Greater(5);
        $expected = false;

        $key = 1;
        $value = null;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $key = null;
        $value = 3;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testFilterWorksAsExpected()
    {
        $filter = new Greater(5);
        $expected = [6];
        $array = [1, 5, 4, 6, 5];

        $actual = [];

        Each::shallow($filter)->begin($array, function($bag) use(&$actual) {
            $actual[] = $bag->value();
        });

        $this->assertEquals($expected, $actual);
    }
}