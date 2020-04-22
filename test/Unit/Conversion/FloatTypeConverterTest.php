<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use Nonetallt\String\Conversion\FloatTypeConverter;

class FloatTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        parent::setUp();
        $this->converter = new FloatTypeConverter;
    }

    public function testCanConvertIntegerString()
    {
        $this->assertEquals(10.0, $this->converter->convert('10'));
    }

    public function testCanConvertFloatString()
    {
        $this->assertEquals(10.2, $this->converter->convert('10.2'));
    }
}

