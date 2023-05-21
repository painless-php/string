<?php

namespace Test\Unit\Conversion;

use PHPUnit\Framework\TestCase;
use PainlessPHP\String\Conversion\StringToFloatTypeConverter;

class StringToFloatTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        $this->converter = new StringToFloatTypeConverter;
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
