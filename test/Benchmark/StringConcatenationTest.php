<?php

namespace Test\Benchmark;

/**
 * @Revs(100000)
 * @Iterations(3)
 * @BeforeMethods({"init"})
 *
 * Test if it's faster to concatenate strings with the concatenation operator
 * or the implode function
 *
 */
class StringConcatenationTest
{
    private $chars;

    public function init()
    {
        $this->chars = str_repeat('a', 10000);
    }

    public function benchConcatenationOperation()
    {
        $result = '';
        foreach($this->chars as $char) {
            $result .= $char;
        }
    }

    public function benchImplode()
    {
        $result = $this->chars;
        implode($result);
    }

    public function benchImplodeFromArray()
    {
        $result = [];
        foreach($this->chars as $char) {
            $result[] = $char;
        }

        implode($result);
    }
}
