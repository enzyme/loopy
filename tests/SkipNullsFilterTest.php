<?php

use Enzyme\Loopy\Filters\SkipNulls;

class SkipNullsFilterTest extends PHPUnit_Framework_TestCase
{
    public function testPassesThroughFilterSuccess()
    {
        $filter = new SkipNulls;
        $expected = true;

        $key = 1;
        $value = 1;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $key = null;
        $value = 1;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }

    public function testPassesThroughFilterFailure()
    {
        $filter = new SkipNulls;
        $expected = false;

        $key = 1;
        $value = null;
        $this->assertEquals($expected, $filter->passes($key, $value));

        $key = null;
        $value = null;
        $this->assertEquals($expected, $filter->passes($key, $value));
    }
}