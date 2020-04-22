<?php

namespace Nonetallt\String\Exception;

use Nonetallt\String\Contract\TypeConverterInterface;

class TypeConversionException extends \Exception
{
    public function __construct(string $message, int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromConversion($value, TypeConverterInterface $converter = null, int $code = 0, \Exception $previous = null) : self
    {
        $class = $converter === null ? '' :  'using ' . get_class($converter);
        $value = is_object($value) ? get_class($value) : gettype($value);
        $message = "Could not convert $value to string";

        return new self($message, $code, $previous);
    }
}
