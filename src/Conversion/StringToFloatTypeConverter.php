<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\StringTypeConverterInterface;
use PainlessPHP\String\Exception\StringTypeConversionException;

class StringToFloatTypeConverter implements StringTypeConverterInterface
{
    public function convert(string $value): float
    {
        if (is_numeric($value)) {
            return (float)$value;
        }

        throw StringTypeConversionException::fromConversion($value, $this);
    }
}
