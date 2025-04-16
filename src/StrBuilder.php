<?php

namespace PainlessPHP\String;

use InvalidArgumentException;
use ReflectionClass;

/**
 *
 *
 * @method static bool startsWith (string $subject, string ...$starts)
 * @method static bool endsWith (string $subject, string ...$ends)
 * @method static string removePrefix (string $subject, string $prefix)
 * @method static string removeSuffix (string $subject, string $suffix)
 * @method static bool startsWithWhitespace (string $subject)
 * @method static array explodeMultiple (string $subject, string ...$delimiters)
 * @method static string removeRecurring (string $subject, string $character)
 * @method static string splice (string $subject, int $start, ?int $length)
 * @method static string afterFirst (string $subject, string $after)
 * @method static string afterLast (string $subject, string $after)
 * @method static string beforeFirst (string $subject, string $before)
 * @method static string beforeLast (string $subject, string $before)
 * @method static bool contains (string $subject, string $another)
 * @method static array diff (string $subject, string $another)
 * @method static bool isConvertable ($value)
 * @method static string convertFrom ($value)
 * @method static convertTo (string $value, PainlessPHP\String\Contract\StringTypeConverterInterface|string $converter)
 * @method static string describe ($value)
 * @method static string random (int $length, array|string|null $characters)
 * @method static array latinAlphabet (bool $includeUpper)
 * @method static array alphanumeric (bool $includeUpper, array|string|null $characters)
 * @method static string addPrefix (string $subject, string $prefix)
 * @method static string addSuffix (string $subject, string $suffix)
 * @method static string removeLeading (string $subject, string ...$prefixes)
 * @method static string removeTrailing (string $subject, string ...$suffixes)
 * @method static string toSnakeCase (string $subject, array $convertedCharacters)
 * @method static string toKebabCase (string $subject, array $convertedCharacters)
 * @method static array characters (string $subject, bool $unique)
 * @method static string findFirstWordContaining (string $subject, string $search)
 * @method static array findAllWordsContaining (string $subject, string $search)
 * @method static PainlessPHP\String\StrBuilder build (string $subject)
 * @method static string replaceAll (string $subject, string $search, string $replace)
 * @method static string replaceAllArray (string $subject, array $replacements)
 * @method static string replacePrefix (string $subject, string $prefix, string $replacement)
 * @method static string replaceSuffix (string $subject, string $suffix, string $replacement)
 * @method static join (?string $glue, mixed ...$parts)
 */
class StrBuilder
{
    private static array|null $callableStrMethods = null;
    private static array|null $strMethodsWithSubject = null;
    private static array|null $argumentListFormatters = null;

    // Introduce $builder->str accessor and bump required php version to 8.4
    // public string $str {
    //     get => $this->string;
    // }

    public function __construct(public readonly string $string)
    {
    }

    public function __toString() : string
    {
        return $this->string;
    }

    public function __call(string $name, array $arguments)
    {
        if(!array_key_exists($name, self::getCallableStrMethods())) {
            $msg = "Method '$name' does not exist.";
            throw new InvalidArgumentException($msg);
        }

        if(array_key_exists($name, self::getArgumentListFormatters())) {
            $arguments = self::getArgumentListFormatters()[$name]($this->string, $arguments);
        }
        else if(!array_key_exists($name, self::getStrMethodsWithSubject())) {
            $msg = "Method '$name' cannot be invoked dynamically.";
            throw new InvalidArgumentException($msg);
        }
        else {
            $arguments = [$this->string, ...$arguments];
        }

        $result = Str::$name(...$arguments);

        if(is_string($result)) {
            return new self($result);
        }

        return $result;
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if(!array_key_exists($name, self::getCallableStrMethods())) {
            $msg = "Method '$name' does not exist.";
            throw new InvalidArgumentException($msg);
        }

        $result = Str::$name(...$arguments);

        if(is_string($result)) {
            return new self($result);
        }

        return $result;
    }

    private static function loadStrMethodsWithSubject() : array
    {
        $methods = [];

        foreach(self::getCallableStrMethods() as $reflectionMethod) {

            $firstParam = $reflectionMethod->getParameters()[0] ?? null;

            if($firstParam === null) {
                continue;
            }

            if((string)$firstParam->getType() !== 'string') {
                continue;
            }

            $methods[$reflectionMethod->name] = $reflectionMethod;
        }

        return $methods;
    }

    private static function loadCallableStrMethods() : array
    {
        $classReflection = new ReflectionClass(Str::class);
        $reflectionMethods = $classReflection->getMethods();

        $methods = [];

        foreach($reflectionMethods as $reflectionMethod) {
            if(! $reflectionMethod->isStatic() || ! $reflectionMethod->isPublic()) {
                continue;
            }

            $methods[$reflectionMethod->name] = $reflectionMethod;
        }

        return $methods;
    }

    private static function getCallableStrMethods() : array
    {
        if(self::$callableStrMethods === null) {
            self::$callableStrMethods = self::loadCallableStrMethods();
        }

        return self::$callableStrMethods;
    }

    private static function getStrMethodsWithSubject() : array
    {
        if(self::$strMethodsWithSubject === null) {
            self::$strMethodsWithSubject = self::loadStrMethodsWithSubject();
        }

        return self::$strMethodsWithSubject;
    }

    private static function loadArgumentListFormatters() : array
    {
        return [
            'join' => fn(string $string, array $arguments) => (
                [array_shift($arguments), ...[$string, ...$arguments]]
            )
        ];
    }

    private static function getArgumentListFormatters() : array
    {
        if(self::$argumentListFormatters === null) {
            self::$argumentListFormatters = self::loadArgumentListFormatters();
        }

        return self::$argumentListFormatters;
    }
}
