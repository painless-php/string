<?php

namespace Test\Unit;

use PainlessPHP\String\StrBuilder;
use PHPUnit\Framework\TestCase;

class StrBuilderTest extends TestCase
{
    public function testBuilderCanCallStrMethods()
    {
        $builder = new StrBuilder('foo');
        $this->assertEquals(['f', 'o', 'o'], $builder->characters());
    }

    public function testBuilderCanChainMethodsThatReturnString()
    {
        $builder = new StrBuilder('foobarbaz');
        $result = $builder->removePrefix('foo')->removeSuffix('baz');

        // Assert that a str builder was chained
        $this->assertInstanceOf(StrBuilder::class, $result);

        // Assert that the builder is a new instance
        $this->assertNotEquals($builder, $result);

        // Assert that the method returned correct result
        $this->assertEquals('bar', $result->string);
    }

    public function testBuilderCanCreateNewInstanceFromStaticStrMethod()
    {
        $builder = StrBuilder::random(1, 'a');
        $this->assertInstanceOf(StrBuilder::class, $builder);
        $this->assertEquals('a', $builder->string);
    }
}
