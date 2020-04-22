<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use Nonetallt\String\Conversion\BooleanTypeConverter;

class BooleanTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        parent::setUp();
        $this->converter = new BooleanTypeConverter;
    }

    public function testCanConvertTrueString()
    {
        $this->assertTrue($this->converter->convert('true'));
    }

    public function testCanConvertFalseString()
    {
        $this->assertFalse($this->converter->convert('false'));
    }

    public function testCanConvertNumericTrue()
    {
        $this->assertTrue($this->converter->convert('1'));
    }

    public function testCanConvertNumericFalse()
    {
        $this->assertFalse($this->converter->convert('0'));
    }
}

