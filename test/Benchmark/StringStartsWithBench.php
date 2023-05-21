<?php

namespace Test\Benchmark;

use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

/**
 * @Revs(100)
 * @Iterations(3)
 * @BeforeMethods({"init"})
 *
 * Test if it's faster to use builtin str_starts_with compared to custom implementation
 * or the implode function
 *
 */
class StringStartsWithBench
{
    private $subject;

    public function init()
    {
        $this->subject = 'foobarbaz';
    }

    public function benchCustom()
    {
        $start = 'foo';
        $subjectStart = mb_substr($this->subject, 0, mb_strlen($start));
        return $subjectStart === $start;

    }

    public function benchBuiltin()
    {
        return str_starts_with($this->subject, 'foo');
    }
}
