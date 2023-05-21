<?php

namespace PainlessPHP\String\Conversion;

use PainlessPHP\String\Contract\TypeConverterInterface;
use PainlessPHP\String\Exception\TypeConversionException;

class NullTypeConverter implements TypeConverterInterface
{
    public function convert(string $value)
    {
        if($value === 'null' || $value === '') {
            return null;
        }

        throw TypeConversionException::fromConversion($value, $this);
    }
}
