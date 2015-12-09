<?php

use Enzyme\Loopy\Each;
use Mockery as m;

class EachTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testStandardShallowBegin()
    {
        $expected = 1;
        $array = [1, 2, 3];

        Each::shallow()->begin($array, function($bag) use(&$expected) {
            $actual = $bag->value();
            $this->assertEquals($expected, $actual);

            $expected++;
        });
    }

    public function testFilterIsExecuted()
    {
        $expected = 1;
        $array = [1, 2, 3];
        $filter = m::mock('Enzyme\Loopy\Filters\FilterInterface', function($mock) {
            $mock->shouldReceive('passes')->times(3)->andReturn(true);
        });

        Each::shallow($filter)->begin($array, function($bag) use(&$expected) {
            $actual = $bag->value();
            $this->assertEquals($expected, $actual);

            $expected++;
        });
    }

    /**
     * @expectedException \Enzyme\Loopy\InvalidLoopException
     */
    public function testNonEnumerableArgument()
    {
        $expected = 1;
        $array = 'foobar';

        Each::shallow()->begin($array, function($bag) use(&$expected) {
            // Should throw an exception before getting here.
        });
    }

    public function testStandardShallowBeginMultipleCycles()
    {
        $expected = 1;
        $cycles = 2;
        $cur_cycle = 0;
        $array = [1, 2, 3];

        Each::shallow()->begin($array, function($bag) use(&$expected, &$cur_cycle, $array) {
            $actual = $bag->value();
            $this->assertEquals($expected, $actual);

            $expected++;

            $actual = $bag->cycle();
            $this->assertEquals($cur_cycle, $actual);

            if ($expected > $array[count($array) - 1]) {
                $expected = 1;
                $cur_cycle++;
            }
        }, $cycles);
    }

    public function testStandardDeepBegin()
    {
        $expected = 1;
        $array = [1, 2, 3, 4 => [4, 5, 6]];

        Each::deep()->begin($array, function($bag) use(&$expected) {
            $actual = $bag->value();
            $this->assertEquals($expected, $actual);

            $expected++;
        });
    }

    public function testStandardDeepBeginMultipleCycles()
    {
        $expected = 1;
        $cycles = 2;
        $cur_cycle = 0;
        $array = [1, 2, 3, 4 => [4, 5, 6]];

        Each::deep()->begin($array, function($bag) use(&$expected, &$cur_cycle, $array) {
            $actual = $bag->value();
            $this->assertEquals($expected, $actual);

            $expected++;

            $actual = $bag->cycle();
            $this->assertEquals($cur_cycle, $actual);

            // Here the number six refers to the last item in the
            // array [1, 2, 3, 4 => [4, 5, 6]] if it were flattened.
            if ($expected > 6) {
                $expected = 1;
                $cur_cycle++;
            }
        }, $cycles);
    }

    public function testExtraDeepBeginMultipleCyclesAndFollowIndex()
    {
        $expected = 1;
        $cycles = 5;
        $cur_cycle = 0;
        $array = [1, 2, 3, 4 => [4, 5, 6 => [6, 7, 8, 9]]];
        $index = 0;

        Each::deep()->begin($array, function($bag) use(&$expected, &$cur_cycle, &$index, $array) {
            $actual = $bag->value();
            $this->assertEquals($expected, $actual);

            $expected++;

            $actual = $bag->cycle();
            $this->assertEquals($cur_cycle, $actual);

            $actual = $bag->index();
            $this->assertEquals($index, $actual);
            $index++;

            // Here the number six refers to the last item in the
            // array [1, 2, 3, 4 => [4, 5, 6 => [6, 7, 8, 9]]] if it were flattened.
            if ($expected > 9) {
                $expected = 1;
                $cur_cycle++;
            }
        }, $cycles);
    }
}