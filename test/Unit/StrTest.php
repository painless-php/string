<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use PainlessPHP\String\Str;
use PainlessPHP\String\Exception\StringTypeConversionException;
use PainlessPHP\String\Exception\StringSearchException;
use PainlessPHP\String\StrBuilder;

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
        $this->assertSame('te heae me aaa', Str::removeRecurring('tee heaee meee aaa', 'e'));
    }

    public function testStrSpliceReturnsRemoveString()
    {
        $str = '0123456';
        $this->assertSame('1234', Str::splice($str, 1, 4));
    }

    public function testStrSpliceRemovesSplicedPartFromString()
    {
        $str = '0123456';
        Str::splice($str, 1, 4);
        $this->assertSame('056', $str);
    }

    public function testStrSpliceCanBeUsedWithoutThirdArgument()
    {
        $str = '0123456';
        $this->assertSame('123456', Str::splice($str, 1));
    }

    public function testStrSpliceModifiesSubjectCorrectlyWithoutThridArgument()
    {
        $str = '0123456';
        Str::splice($str, 2);
        $this->assertSame('01', $str);
    }

    public function testStrSliceReturnsCorrectStringOnComplexString()
    {
        $str = '123456789Kappa123456789';
        $this->assertSame('Kappa', Str::splice($str, 9, 5));
    }

    public function testStrSliceModifiesSubjectCorrectlyOnComplexString()
    {
        $str = '123456789Kappa123456789';
        Str::splice($str, 9, 5);
        $this->assertSame('123456789123456789', $str);
    }

    public function testStrAfterFirstReturnStringAfterSpecifiedString()
    {
        $delimiter = "[something]";
        $subject = "before{$delimiter}after";

        $this->assertSame('after', Str::afterFirst($subject, $delimiter));
    }

    public function testStrBeforeFirstReturnStringBeforeSpecifiedString()
    {
        $delimiter = "[something]";
        $subject = "before{$delimiter}after";

        $this->assertSame('before', str::beforeFirst($subject, $delimiter));
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
        $this->assertSame(50, strlen(Str::random(50, 'abc')));
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
        $this->assertSame('55555', Str::random(5, '5'));
    }

    public function testRandomWorksWithoutSecondArg()
    {
        $this->assertSame(10, strlen(Str::random(10)));
    }

    public function testConvertToFindsConverterByMappingName()
    {
        $this->assertEquals(10.2, Str::convertTo('10.2', 'float'));
    }

    public function testStringTypeConversionExceptionIsThrownWhenConversionMappingIsNotFound()
    {
        $this->expectException(StringTypeConversionException::class);
        Str::convertTo('foo', 'kappa');
    }

    public function testConvertToReturnsOriginalValueWhenConvertingToString()
    {
        $this->assertEquals('foo', Str::convertTo('foo', 'string'));
    }

    public function testRemovePrefixRemovesLeadingPrefix()
    {
        $this->assertSame('Keepo', Str::removePrefix('KappaKeepo', 'Kappa'));
    }

    public function testRemoveSuffixRemovesTrailingSuffix()
    {
        $this->assertSame('Kappa', Str::removeSuffix('KappaKeepo', 'Keepo'));
    }

    public function testAddPrefixAddsGivenPrefix()
    {
        $this->assertSame('KeepoKappa', Str::addPrefix('Kappa', 'Keepo'));
    }

    public function testAddPrefixDoesNotAddPrefixIfStringIsAlreadyPrefixed()
    {
        $this->assertSame('KeepoKappa', Str::addPrefix('KeepoKappa', 'Keepo'));
    }

    public function testAddSuffixAddsGivenSuffix()
    {
        $this->assertSame('KappaKeepo', Str::addSuffix('Kappa', 'Keepo'));
    }

    public function testAddSuffixDoesNotAddSuffixIfStringIsAlreadySuffixed()
    {
        $this->assertSame('KappaKeepo', Str::addSuffix('KappaKeepo', 'Keepo'));
    }

    public function testRemoveLeadingRemovesLeadingSequences()
    {
        $this->assertSame('Baz', Str::removeLeading('FooBarBaz', 'Bar', 'Foo'));
    }

    public function testRemoveTrailingRemovesTrailingCharacters()
    {
        $this->assertSame('Foo', Str::removeTrailing('FooBarBaz', 'Bar', 'Baz'));
    }

    public function testToSnakeCaseConvertsPascalCaseToSnakeCase()
    {
        $this->assertSame('product_filter', Str::toSnakeCase('ProductFilter'));
    }

    public function testToSnakeCaseConvertsCamelCaseToSnakeCase()
    {
        $this->assertSame('product_filter', Str::toSnakeCase('productFilter'));
    }

    public function testToSnakeCaseDoesNotAddUnderscoreAfterFirstOrLastCharacter()
    {
        $this->assertSame('product_filter', Str::toSnakeCase('ProductFilteR'));
    }

    public function testToKebabCaseConvertsPascalCaseToKebabCase()
    {
        $this->assertSame('product-filter', Str::toKebabCase('ProductFilter'));
    }

    public function testToKebabCaseConvertsCamelCaseToKebabCase()
    {
        $this->assertSame('product-filter', Str::toKebabCase('productFilter'));
    }

    public function testToKebabCaseDoesNotAddUnderscoreAfterFirstOrLastCharacter()
    {
        $this->assertSame('product-filter', Str::toKebabCase('ProductFilteR'));
    }

    public function testFindFirstWordContainingReturnsTheWordContainingGivenSearch()
    {
        $subject = 'example example{placeholder}stuff {placeholder}';
        $this->assertSame('example{placeholder}stuff', Str::findFirstWordContaining($subject, '{placeholder}'));
    }

    public function testFindFirstWordContainingThrowsExceptionIfSearchIsNotFound()
    {
        $this->expectException(StringSearchException::class);
        Str::findFirstWordContaining('foo', 'bar');
    }

    public function testFindALlWordsContainingReturnsAllWordsContainingTheGivenSearch()
    {
        $subject = 'example example{placeholder}stuff {placeholder}';
        $this->assertEquals(['example{placeholder}stuff', '{placeholder}'], Str::findAllWordsContaining($subject, '{placeholder}'));
    }

    public function testBuildReturnsStrBuilderInstance()
    {
        $string =  'string';
        $builder = Str::build($string);
        $this->assertInstanceOf(StrBuilder::class, $builder);
        $this->assertEquals($string, $builder->string);
    }

    public function testAfterLastReturnsStringAfterLastInstance()
    {
        $this->assertSame('Validation', Str::afterLast('TestControllerTestValidation', 'Test'));;
    }

    public function testBeforeLastReturnsStringBeforeLastInstance()
    {
        $this->assertSame('TestController', Str::beforeLast('TestControllerTestValidation', 'Test'));;
    }

    public function testReplaceAllReplacesSearchInstances()
    {
        $this->assertSame('foo baz baz', Str::replaceAll('foo bar bar', 'bar', 'baz'));;
    }

    public function testReplaceAllArrayReplacesSearchInstances()
    {
        $replacements = [
            '{{foo}}' => 'value1',
            '{{bar}}' => 'value2'
        ];

        $this->assertSame('foo=value1&bar=value2', Str::replaceAllArray('foo={{foo}}&bar={{bar}}', $replacements));;
    }

    public function testReplacePrefixReplacesPrefix()
    {
        $this->assertSame('foo bar baz', Str::replacePrefix('bar bar baz', 'bar', 'foo'));;
    }

    public function testReplacePrefixDoesNotChangeStringWhenPrefixIsNotFound()
    {
        $this->assertSame('foo bar baz', Str::replacePrefix('foo bar baz', 'bar', 'foo'));;
    }

    public function testReplaceSuffix()
    {
        $this->assertSame('foo bar baz', Str::replaceSuffix('foo bar foo', 'foo', 'baz'));;
    }

    public function testReplaceSuffixDoesNotChangeStringWhenSuffixIsNotFound()
    {
        $this->assertSame('foo bar baz', Str::replaceSuffix('foo bar baz', 'bar', 'foo'));;
    }

    public function testJoinAttachesTwoParts()
    {
        $this->assertSame('foo/bar', Str::join('/', 'foo', 'bar'));
    }

    public function testJoinAttachesThreeeParts()
    {
        $this->assertSame('foo/bar/baz', Str::join('/', 'foo', 'bar', 'baz'));
    }

    public function testJoinIgnoresNullParts()
    {
        $this->assertSame('foo/baz', Str::join('/', 'foo', null, 'baz'));
    }

    public function testJoiningNullsResultsInEmptyString()
    {
        $this->assertSame('', Str::join('/', null, null, null));
    }

    public function testJoinWithFirstValueNullWorks()
    {
        $this->assertSame('bar/baz', Str::join('/', null, 'bar', 'baz'));
    }

    public function testJoinWithLastValueNullWorks()
    {
        $this->assertSame('foo/bar', Str::join('/', 'foo', 'bar', null));
    }

    public function testJoinCanBeCalledViaBuilder()
    {
        $this->assertSame('foo/bar/baz', Str::build('foo')->join('/', 'bar', 'baz')->string);
    }
}
