<?php

use Enzyme\Loopy\Each;
use Enzyme\Loopy\Filters\Equal;

class EqualFilterTest extends PHPUnit_Framework_TestCase
{
    public function testPassesThroughFilterSuccess()
    {
        $filter = new Equal(5);
        $expected = true;

        $key = 1;
        $value = 5;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $filter = new Equal(1009);

        $key = null;
        $value = 1009;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testPassesThroughFilterFailure()
    {
        $filter = new Equal(5);
        $expected = false;

        $key = 1;
        $value = null;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $key = null;
        $value = 10;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testFilterWorksAsExpected()
    {
        $filter = new Equal(5);
        $expected = [5, 5];
        $array = [1, 5, 4, 6, 5];

        $actual = [];

        Each::shallow($filter)->begin($array, function($bag) use(&$actual) {
            $actual[] = $bag->value();
        });

        $this->assertEquals($expected, $actual);
    }
}