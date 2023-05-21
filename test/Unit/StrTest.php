<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use PainlessPHP\String\Str;
use PainlessPHP\String\Exception\TypeConversionException;

class StrTest extends TestCase
{
    public function testStartsWithReturnsTrueWhenSubjectStartsWithCorrectString()
    {
        $this->assertTrue(Str::startsWith('test123', 'tes'));
    }

    public function testStartsWithReturnsFalseWhenSubjectStartsWithIncorrectString()
    {
        $this->assertFalse(Str::startsWith('test123', 'es'));
    }

    public function testEndsWithReturnsTrueWhenSubjectEndsWithCorrectString()
    {
        $this->assertTrue(Str::endsWith('test123', '123'));
    }

    public function testEndsWithReturnFalseWhenSubjectEndsWithIncorrectString()
    {
        $this->assertFalse(Str::endsWith('test123', '13'));
    }

    public function testStartsWithWhitespaceTrue()
    {
        $this->assertTrue(Str::startsWithWhitespace('  asd'));
    }

    public function testStartsWithWhitespaceFalse()
    {
        $this->assertFalse(Str::startsWithWhitespace('asd'));
    }

    public function testExplodeMultiple()
    {
        $expected = [
            'test1',
            'test2',
            'test3',
            'test4'
        ];
        $this->assertEquals($expected, Str::explodeMultiple('test1,test2 test3|test4', ' ', ',', '|'));
    }

    public function testStrRemoveRecurringErrorsWithLongerThanOneCharacterArgument()
    {
        $this->expectExceptionMessage('Given character must be a string with a length of 1 character.');
        Str::removeRecurring('testi123', '12');
    }

    public function testStrRemoveRecurring()
    {
        $this->assertEquals('te heae me aaa', Str::removeRecurring('tee heaee meee aaa', 'e'));
    }

    public function testStrSpliceReturnsRemoveString()
    {
        $str = '0123456';
        $this->assertEquals('1234', Str::splice($str, 1, 4));
    }

    public function testStrSpliceRemovesSplicedPartFromString()
    {
        $str = '0123456';
        Str::splice($str, 1, 4);
        $this->assertEquals('056', $str);
    }

    public function testStrSpliceCanBeUsedWithoutThirdArgument()
    {
        $str = '0123456';
        $this->assertEquals('123456', Str::splice($str, 1));
    }

    public function testStrSpliceModifiesSubjectCorrectlyWithoutThridArgument()
    {
        $str = '0123456';
        Str::splice($str, 2);
        $this->assertEquals('01', $str);
    }

    public function testStrSliceReturnsCorrectStringOnComplexString()
    {
        $str = '123456789Kappa123456789';
        $this->assertEquals('Kappa', Str::splice($str, 9, 5));
    }

    public function testStrSliceModifiesSubjectCorrectlyOnComplexString()
    {
        $str = '123456789Kappa123456789';
        Str::splice($str, 9, 5);
        $this->assertEquals('123456789123456789', $str);
    }

    public function testStrAfterReturnStringAfterSpecifiedString()
    {
        $delimiter = "[something]";
        $subject = "before{$delimiter}after";

        $this->assertEquals('after', Str::after($subject, $delimiter));
    }

    public function testStrBeforeReturnStringBeforeSpecifiedString()
    {
        $delimiter = "[something]";
        $subject = "before{$delimiter}after";

        $this->assertEquals('before', str::before($subject, $delimiter));
    }

    public function testContainsReturnsTrueWhenSubjectContainsTarget()
    {
        $this->assertTrue(Str::contains('foobarbaz', 'bar'));
    }

    public function testContainsReturnsFalseWhenSubjectDoesNotContainTarget()
    {
        $this->assertFalse(Str::contains('foobarbaz', 'fooo'));
    }

    public function testRandomReturnsStringOfSpecifiedLength()
    {
        $this->assertEquals(50, strlen(Str::random(50, 'abc')));
    }

    public function testRandomContainsOnlySpecifiedCharacters()
    {
        $chars = range('a', 'z');
        $str = Str::random(30, $chars);

        foreach(str_split($str) as $char) {
            $this->assertContains($char, $chars);
        }
    }

    public function testRandomReturnsSequenceOfSingleCharacterIfCharactersContainOnly1Character()
    {
        $this->assertEquals('55555', Str::random(5, '5'));
    }

    public function testRandomWorksWithoutSecondArg()
    {
        $this->assertEquals(10, strlen(Str::random(10)));
    }

    public function testConvertToFindsConverterByMappingName()
    {
        $this->assertEquals(10.2, Str::convertTo('10.2', 'float'));
    }

    public function testTypeConversionExceptionIsThrownWhenConversionMappingIsNotFound()
    {
        $this->expectException(TypeConversionException::class);
        Str::convertTo('foo', 'kappa');
    }

    public function testConvertToReturnsOriginalValueWhenConvertingToString()
    {
        $this->assertEquals('foo', Str::convertTo('foo', 'string'));
    }

    public function testRemovePrefixRemovesLeadingPrefix()
    {
        $this->assertEquals('Keepo', Str::removePrefix('KappaKeepo', 'Kappa'));
    }

    public function testRemoveSuffixRemovesTrailingSuffix()
    {
        $this->assertEquals('Kappa', Str::removeSuffix('KappaKeepo', 'Keepo'));
    }

    public function testAddPrefixAddsGivenPrefix()
    {
        $this->assertEquals('KeepoKappa', Str::addPrefix('Kappa', 'Keepo'));
    }

    public function testAddPrefixDoesNotAddPrefixIfStringIsAlreadyPrefixed()
    {
        $this->assertEquals('KeepoKappa', Str::addPrefix('KeepoKappa', 'Keepo'));
    }

    public function testAddSuffixAddsGivenSuffix()
    {
        $this->assertEquals('KappaKeepo', Str::addSuffix('Kappa', 'Keepo'));
    }

    public function testAddSuffixDoesNotAddSuffixIfStringIsAlreadySuffixed()
    {
        $this->assertEquals('KappaKeepo', Str::addSuffix('KappaKeepo', 'Keepo'));
    }

    public function testRemoveLeadingRemovesLeadingSequences()
    {
        $this->assertEquals('Baz', Str::removeLeading('FooBarBaz', 'Bar', 'Foo'));
    }

    public function testRemoveTrailingRemovesTrailingCharacters()
    {
        $this->assertEquals('Foo', Str::removeTrailing('FooBarBaz', 'Bar', 'Baz'));
    }

    public function testToSnakeCaseConvertsPascalCaseToSnakeCase()
    {
        $this->assertEquals('product_filter', Str::toSnakeCase('ProductFilter'));
    }

    public function testToSnakeCaseConvertsCamelCaseToSnakeCase()
    {
        $this->assertEquals('product_filter', Str::toSnakeCase('productFilter'));
    }

    public function testToSnakeCaseDoesNotAddUnderscoreAfterFirstOrLastCharacter()
    {
        $this->assertEquals('product_filter', Str::toSnakeCase('ProductFilteR'));
    }

    public function testToKebabCaseConvertsPascalCaseToKebabCase()
    {
        $this->assertEquals('product-filter', Str::toKebabCase('ProductFilter'));
    }

    public function testToKebabCaseConvertsCamelCaseToKebabCase()
    {
        $this->assertEquals('product-filter', Str::toKebabCase('productFilter'));
    }

    public function testToKebabCaseDoesNotAddUnderscoreAfterFirstOrLastCharacter()
    {
        $this->assertEquals('product-filter', Str::toKebabCase('ProductFilteR'));
    }
}
