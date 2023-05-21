<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\TypeConverterInterface;
use PainlessPHP\String\Exception\TypeConversionException;

class BooleanTypeConverter implements TypeConverterInterface
{
    public function convert(string $value) : bool
    {
        if($value === 'true' || $value === '1') {
            return true;
        }

        if($value === 'false' || $value === '0') {
            return false;
        }

        throw TypeConversionException::fromConversion($value, $this);
    }
}
