<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use Nonetallt\Templating\PlaceholderFormat;
use Nonetallt\String\Str;

class IsStrConvertableTest extends TestCase
{
    public function testStringIsConvertable()
    {
        $this->assertTrue(Str::isConvertable('asd'));
    }

    public function testIntegerIsConvertable()
    {
        $this->assertTrue(Str::isConvertable(1));
    }

    public function testFloatIsConvertable()
    {
        $this->assertTrue(Str::isConvertable(1.1));
    }

    public function testNullIsConvertable()
    {
        $this->assertTrue(Str::isConvertable(null));
    }

    public function testTrueIsConvertable()
    {
        $this->assertTrue(Str::isConvertable(true));
    }

    public function testFalseIsConvertable()
    {
        $this->assertTrue(Str::isConvertable(false));
    }

    public function testObjectWithToStringIsConvertable()
    {
        $obj = new class{
            function __toString() {
                return 'foo';
            }
        };

        $this->assertTrue(Str::isConvertable($obj));
    }

    public function testArrayIsNotConvertable()
    {
        $this->assertFalse(Str::isConvertable([]));
    }

    public function testObjectWithoutToStringIsNotConvertable()
    {
        $this->assertFalse(Str::isConvertable($this));
    }
}

