<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\StringTypeConverterInterface;
use PainlessPHP\String\Exception\StringTypeConversionException;

class StringToIntegerTypeConverter implements StringTypeConverterInterface
{
    public function convert(string $value): int
    {
        if (is_numeric($value)) {
            return (int)$value;
        }

        throw StringTypeConversionException::fromConversion($value, $this);
    }
}
