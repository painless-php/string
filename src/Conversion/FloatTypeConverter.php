<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\TypeConverterInterface;
use PainlessPHP\String\Exception\TypeConversionException;

class FloatTypeConverter implements TypeConverterInterface
{
    public function convert(string $value) : float
    {
        if(is_numeric($value)) {
            return floatval($value);
        }

        throw TypeConversionException::fromConversion($value, $this);
    }
}
