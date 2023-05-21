<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\TypeConverterInterface;
use PainlessPHP\String\Exception\TypeConversionException;

class IntegerTypeConverter implements TypeConverterInterface
{
    public function convert(string $value) : int
    {
        if(is_numeric($value)) {
            return intval($value);
        }

        throw TypeConversionException::fromConversion($value, $this);
    }
}
