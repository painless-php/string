<?php

namespace PainlessPHP\String;

use InvalidArgumentException;
use ReflectionClass;

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
