<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\StringTypeConverterInterface;
use PainlessPHP\String\Exception\StringTypeConversionException;

class StringToBooleanTypeConverter implements StringTypeConverterInterface
{
    public function convert(string $value) : bool
    {
        if($value === 'true' || $value === '1') {
            return true;
        }

        if($value === 'false' || $value === '0') {
            return false;
        }

        throw StringTypeConversionException::fromConversion($value, $this);
    }
}
