<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use Nonetallt\String\Conversion\NullTypeConverter;

class NullTypeConverterTest extends TestCase
{
    private $converter;

    public function setUp() : void
    {
        parent::setUp();
        $this->converter = new NullTypeConverter;
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

