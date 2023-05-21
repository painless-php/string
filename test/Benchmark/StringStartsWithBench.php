<?php

namespace Test\Benchmark;

/**
 * @Revs(100)
 * @Iterations(3)
 * @BeforeMethods({"init"})
 *
 * Test if it's faster to concatenate strings with the concatenation operator
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

    public function benchInbuilt()
    {
        return str_starts_with($this->subject, 'foo');
    }
}
