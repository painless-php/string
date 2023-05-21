<?php

namespace PainlessPHP\String\Exception;

use Exception;
use PainlessPHP\String\Contract\StringTypeConverterInterface;

class StringTypeConversionException extends Exception
{
    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromConversion($value, StringTypeConverterInterface $converter = null, int $code = 0, Exception $previous = null) : self
    {
        $class = $converter === null ? '' :  'using ' . get_class($converter);
        $value = get_debug_type($value);
        $message = "Could not convert string $value$class";

        return new self($message, $code, $previous);
    }
}
