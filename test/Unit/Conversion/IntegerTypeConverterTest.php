<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use PainlessPHP\String\Conversion\IntegerTypeConverter;

class IntegerTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        parent::setUp();
        $this->converter = new IntegerTypeConverter;
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
