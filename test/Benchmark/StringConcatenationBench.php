<?php

namespace Test\Benchmark;

use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

/**
 * @Revs(100)
 * @Iterations(3)
 * @BeforeMethods({"init"})
 *
 * Test if it's faster to concatenate strings with the concatenation operator
 * or the implode function
 *
 */
class StringConcatenationBench
{
    private $chars;

    public function init()
    {
        $this->chars = array_fill(0 , 100000, 'a');
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
        implode('', $this->chars);
    }
}
