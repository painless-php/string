<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\StringTypeConverterInterface;
use PainlessPHP\String\Exception\StringTypeConversionException;

class StringToNullTypeConverter implements StringTypeConverterInterface
{
    public function convert(string $value)
    {
        if($value === 'null' || $value === '') {
            return null;
        }

        throw StringTypeConversionException::fromConversion($value, $this);
    }
}
