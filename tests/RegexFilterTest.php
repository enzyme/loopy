<?php

use Enzyme\Loopy\Each;
use Enzyme\Loopy\Filters\Regex;

class RegexFilterTest extends PHPUnit_Framework_TestCase
{
    public function testPassesThroughFilterSuccess()
    {
        $filter = new Regex('/[0-9]+/');
        $expected = true;

        $key = 1;
        $value = 6;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $filter = new Regex('/[0-9]+/');

        $key = null;
        $value = 1010;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testPassesThroughFilterFailure()
    {
        $filter = new Regex('/[0-9]+/');
        $expected = false;

        $key = 1;
        $value = null;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $key = null;
        $value = 'aaaa';
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testFilterWorksAsExpected()
    {
        $filter = new Regex('/[0-9]+/');
        $expected = [5, 6];
        $array = ['a', 5, 'b', 6, 'c'];

        $actual = [];

        Each::shallow($filter)->begin($array, function($bag) use(&$actual) {
            $actual[] = $bag->value();
        });

        $this->assertEquals($expected, $actual);
    }
}