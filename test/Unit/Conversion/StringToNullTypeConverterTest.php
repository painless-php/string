<?php

namespace Test\Unit\Conversion;

use PHPUnit\Framework\TestCase;
use PainlessPHP\String\Conversion\StringToNullTypeConverter;

class StringToNullTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        $this->converter = new StringToNullTypeConverter;
    }

    public function testCanConvertNullString()
    {
        $this->assertNull($this->converter->convert('null'));
    }

    public function testCanConvertEmptyString()
    {
        $this->assertNull($this->converter->convert(''));
    }
}
