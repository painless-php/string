<?php

namespace Test\Unit\Conversion;

use PHPUnit\Framework\TestCase;
use PainlessPHP\String\Conversion\StringToIntegerTypeConverter;

class StringToIntegerTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        $this->converter = new StringToIntegerTypeConverter;
    }

    public function testCanConvertIntegerString()
    {
        $this->assertSame(10, $this->converter->convert('10'));
    }

    public function testCanConvertFloatString()
    {
        $this->assertSame(10, $this->converter->convert('10.2'));
    }
}
