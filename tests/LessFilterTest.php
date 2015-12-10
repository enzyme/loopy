<?php

use Enzyme\Loopy\Each;
use Enzyme\Loopy\Filters\Less;

class LessFilterTest extends PHPUnit_Framework_TestCase
{
    public function testPassesThroughFilterSuccess()
    {
        $filter = new Less(5);
        $expected = true;

        $key = 1;
        $value = 2;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $filter = new Less(1009);

        $key = null;
        $value = 100;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testPassesThroughFilterFailure()
    {
        $filter = new Less(5);
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
        $filter = new Less(5);
        $expected = [1, 4];
        $array = [1, 5, 4, 6, 5];

        $actual = [];

        Each::shallow($filter)->begin($array, function($bag) use(&$actual) {
            $actual[] = $bag->value();
        });

        $this->assertEquals($expected, $actual);
    }
}