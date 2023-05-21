<?php

namespace PainlessPHP\String;

use InvalidArgumentException;
use ReflectionClass;

class StrBuilder
{
    private static array|null $callableStrMethods = null;
    private static array|null $strMethodsWithSubject = null;

    public function __construct(public readonly string $string)
    {
    }

    public function __toString() : string
    {
        return $this->string;
    }

    public function __call(string $name, array $arguments)
    {
        if(! in_array($name, array_keys(self::getCallableStrMethods()))) {
            $msg = "Method '$name' does not exist.";
            throw new InvalidArgumentException($msg);
        }

        if(! in_array($name, array_keys(self::getStrMethodsWithSubject()))) {
            $msg = "Method '$name' cannot be invoked dynamically.";
            throw new InvalidArgumentException($msg);
        }

        $result = Str::$name($this->string, ...$arguments);

        if(is_string($result)) {
            return new self($result);
        }

        return $result;
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if(! in_array($name, array_keys(self::getCallableStrMethods()))) {
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
}
