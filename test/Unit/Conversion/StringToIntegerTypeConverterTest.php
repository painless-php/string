<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use PainlessPHP\String\Conversion\StringToIntegerTypeConverter;

class StringToIntegerTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        parent::setUp();
        $this->converter = new StringToIntegerTypeConverter;
    }

    public function testCanConvertIntegerString()
    {
        $this->assertEquals(10, $this->converter->convert('10'));
    }

    public function testCanConvertFloatString()
    {
        $this->assertEquals(10, $this->converter->convert('10.2'));
    }
}
